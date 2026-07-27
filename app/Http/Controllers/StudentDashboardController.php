<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResponse;
use App\Models\AssessmentResult;
use App\Models\AwarenessSession;
use App\Models\Question;
use App\Services\RecommendationEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Student home: shows their joined session (if any), progress, and quick links.
     */
    public function index()
    {
        $user = Auth::user();

        $currentSession = $this->currentSession($user);

        $latestResult = AssessmentResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $joinedSessionsCount = $user->sessions()->count();

        return view('student.dashboard', compact('currentSession', 'latestResult', 'joinedSessionsCount'));
    }

    /**
     * Show the form to join an awareness session via its code.
     */
    public function showJoinSession(Request $request)
    {
        $prefilledCode = $request->query('code');

        return view('student.session_join', compact('prefilledCode'));
    }

    /**
     * Join an awareness session using its unique session code.
     */
    public function joinSession(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $session = AwarenessSession::where('session_code', strtoupper(trim($request->code)))->first();

        if (!$session) {
            return back()->withInput()->with('error', 'Invalid session code. Please check and try again.');
        }

        if (!$session->is_active) {
            return back()->withInput()->with('error', 'This awareness session is no longer active.');
        }

        $user = Auth::user();

        // Avoid duplicate join records if the student rejoins the same session.
        $user->sessions()->syncWithoutDetaching([
            $session->id => ['joined_at' => now()],
        ]);

        session(['current_awareness_session_id' => $session->id]);

        return redirect()->route('student.assessment')
            ->with('success', "Joined \"{$session->title}\" successfully! You can now take the assessment.");
    }

    /**
     * Show the assessment questions for the student's current session.
     */
    public function showAssessment()
    {
        $user = Auth::user();
        $session = $this->currentSession($user);

        if (!$session) {
            return redirect()->route('student.session.join')
                ->with('error', 'Please join a session before taking the assessment.');
        }

        $existingResult = AssessmentResult::where('user_id', $user->id)
            ->where('awareness_session_id', $session->id)
            ->first();

        if ($existingResult) {
            return redirect()->route('student.results')
                ->with('success', 'You have already completed the assessment for this session.');
        }

        $questions = Question::with('options')->orderBy('category')->get();

        $savedAnswers = AssessmentResponse::where('user_id', $user->id)
            ->where('awareness_session_id', $session->id)
            ->pluck('question_option_id', 'question_id');

        return view('student.assessment', compact('session', 'questions', 'savedAnswers'));
    }

    /**
     * Save (or update) a single answer for the current session.
     */
    public function saveAnswer(Request $request)
    {
        $request->validate([
            'question_id' => ['required', 'exists:questions,id'],
            'question_option_id' => ['required', 'exists:question_options,id'],
        ]);

        $user = Auth::user();
        $session = $this->currentSession($user);

        if (!$session) {
            return response()->json(['message' => 'No active session found.'], 422);
        }

        AssessmentResponse::updateOrCreate(
            [
                'user_id' => $user->id,
                'awareness_session_id' => $session->id,
                'question_id' => $request->question_id,
            ],
            [
                'question_option_id' => $request->question_option_id,
            ]
        );

        return response()->json(['message' => 'Answer saved.']);
    }

    /**
     * Complete the assessment: compute recommendations and store the result.
     */
    public function completeAssessment(RecommendationEngine $engine)
    {
        $user = Auth::user();
        $session = $this->currentSession($user);

        if (!$session) {
            return redirect()->route('student.session.join')
                ->with('error', 'Please join a session before completing the assessment.');
        }

        $totalQuestions = Question::count();
        $answeredQuestions = AssessmentResponse::where('user_id', $user->id)
            ->where('awareness_session_id', $session->id)
            ->count();

        if ($totalQuestions === 0 || $answeredQuestions < $totalQuestions) {
            return redirect()->route('student.assessment')
                ->with('error', 'Please answer all questions before submitting.');
        }

        $recommendation = $engine->calculate($user->id, $session->id);

        AssessmentResult::updateOrCreate(
            [
                'user_id' => $user->id,
                'awareness_session_id' => $session->id,
            ],
            [
                'top_careers' => $recommendation['top_careers'],
                'career_scores' => $recommendation['career_scores'],
            ]
        );

        return redirect()->route('student.results')
            ->with('success', 'Assessment completed! Here are your career recommendations.');
    }

    /**
     * Show the student's most recent assessment result.
     */
    public function showResults()
    {
        $user = Auth::user();

        $result = AssessmentResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('student.results', compact('result'));
    }

    /**
     * Resolve the student's current awareness session, preferring the one
     * stored in the browser session, falling back to their most recently joined session.
     */
    private function currentSession($user): ?AwarenessSession
    {
        $sessionId = session('current_awareness_session_id');

        if ($sessionId) {
            $session = AwarenessSession::find($sessionId);
            if ($session && $user->sessions()->where('awareness_session_id', $session->id)->exists()) {
                return $session;
            }
        }

        return $user->sessions()->orderBy('student_sessions.joined_at', 'desc')->first();
    }
}
