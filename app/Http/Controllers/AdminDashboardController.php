<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AwarenessSession;
use App\Models\AssessmentResult;
use App\Models\CareerPath;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Core Metrics
        $totalStudents = User::where('role', 'student')->count();
        $totalSessions = AwarenessSession::count();
        $activeSessionsCount = AwarenessSession::where('is_active', true)->count();
        $totalAssessmentsCompleted = AssessmentResult::count();

        // 2. Chart 1: Session-wise participation
        $sessionsData = AwarenessSession::withCount('students')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $sessionLabels = $sessionsData->pluck('title')->toArray();
        $sessionCounts = $sessionsData->pluck('students_count')->toArray();

        // 3. Chart 2: Career distribution (Number of students with a career as their #1 recommendation)
        $allResults = AssessmentResult::all();
        $careerDistribution = [];
        $careers = CareerPath::pluck('name', 'code')->toArray();
        
        foreach ($careers as $code => $name) {
            $careerDistribution[$name] = 0;
        }

        foreach ($allResults as $result) {
            $topCareers = $result->top_careers;
            if (is_array($topCareers) && count($topCareers) > 0) {
                $topCareerCode = $topCareers[0]['code'] ?? null;
                $topCareerName = $careers[$topCareerCode] ?? null;
                if ($topCareerName) {
                    $careerDistribution[$topCareerName]++;
                }
            }
        }
        
        // Filter out careers with 0 count to keep chart clean if needed, or keep all
        $careerLabels = array_keys($careerDistribution);
        $careerCounts = array_values($careerDistribution);

        // 4. Chart 3: Department-wise interest
        // Find which careers are recommended as #1 for students in each department
        $resultsWithUser = AssessmentResult::with('user')->get();
        $deptInterest = []; // ['Science & Tech' => ['AI' => 3, 'DevOps' => 1], ...]

        foreach ($resultsWithUser as $result) {
            if ($result->user && $result->user->department) {
                $dept = $result->user->department;
                $topCareers = $result->top_careers;
                if (is_array($topCareers) && count($topCareers) > 0) {
                    $topCareerCode = $topCareers[0]['code'] ?? 'Unknown';
                    $topCareerName = $careers[$topCareerCode] ?? $topCareerCode;
                    
                    if (!isset($deptInterest[$dept])) {
                        $deptInterest[$dept] = [];
                    }
                    if (!isset($deptInterest[$dept][$topCareerName])) {
                        $deptInterest[$dept][$topCareerName] = 0;
                    }
                    $deptInterest[$dept][$topCareerName]++;
                }
            }
        }

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalSessions',
            'activeSessionsCount',
            'totalAssessmentsCompleted',
            'sessionLabels',
            'sessionCounts',
            'careerLabels',
            'careerCounts',
            'deptInterest'
        ));
    }

    public function students(Request $request)
    {
        $query = User::where('role', 'student')->with('results');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get all unique departments for the filter dropdown
        $departments = User::where('role', 'student')
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->toArray();

        return view('admin.students', compact('students', 'departments'));
    }

    public function studentResults($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $result = AssessmentResult::where('user_id', $id)->first(); // overall or first result

        return view('admin.student_results', compact('student', 'result'));
    }

    public function deleteStudent($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students')
            ->with('success', 'Student account deleted successfully.');
    }
}
