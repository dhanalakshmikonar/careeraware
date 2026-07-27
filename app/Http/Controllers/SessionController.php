<?php

namespace App\Http\Controllers;

use App\Models\AwarenessSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = AwarenessSession::withCount('students')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Generate a unique 6-character uppercase code
        do {
            $code = strtoupper(Str::random(6));
        } while (AwarenessSession::where('session_code', $code)->exists());

        AwarenessSession::create([
            'title' => $request->title,
            'description' => $request->description,
            'session_code' => $code,
            'date' => $request->date,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Awareness Session created successfully.');
    }

    public function show(AwarenessSession $session)
    {
        // Get the list of students who joined this session
        $students = $session->students()
            ->orderBy('student_sessions.joined_at', 'desc')
            ->paginate(15);

        // Generate the join URL
        $joinUrl = route('student.session.join') . '?code=' . $session->session_code;

        return view('admin.sessions.show', compact('session', 'students', 'joinUrl'));
    }

    public function edit(AwarenessSession $session)
    {
        return view('admin.sessions.edit', compact('session'));
    }

    public function update(Request $request, AwarenessSession $session)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'is_active' => ['required', 'boolean'],
        ]);

        $session->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Awareness Session updated successfully.');
    }

    public function destroy(AwarenessSession $session)
    {
        $session->delete();

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Awareness Session deleted successfully.');
    }
}
