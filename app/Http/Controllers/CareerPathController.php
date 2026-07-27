<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    public function index()
    {
        $careers = CareerPath::orderBy('name')->paginate(10);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:career_paths,code', 'alpha_dash'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'salary_range' => ['required', 'string'],
            'demand_status' => ['required', 'string'],
            'skills' => ['required', 'string'], // comma-separated or separate array
            'certifications' => ['required', 'string'], // comma-separated
            'projects' => ['required', 'array'], // array of strings
            'roadmap' => ['required', 'array'], // array of strings
            'strengths' => ['required', 'array'],
            'weaknesses' => ['required', 'array'],
            'opportunities' => ['required', 'array'],
            'threats' => ['required', 'array'],
        ]);

        // Helper to convert comma separated strings to arrays
        $skillsArr = array_map('trim', explode(',', $request->skills));
        $certsArr = array_map('trim', explode(',', $request->certifications));

        // Filter empty inputs from arrays
        $projectsArr = array_filter(array_map('trim', $request->projects));
        $roadmapArr = array_filter(array_map('trim', $request->roadmap));

        $swot = [
            'strengths' => array_filter(array_map('trim', $request->strengths)),
            'weaknesses' => array_filter(array_map('trim', $request->weaknesses)),
            'opportunities' => array_filter(array_map('trim', $request->opportunities)),
            'threats' => array_filter(array_map('trim', $request->threats)),
        ];

        CareerPath::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'salary_range' => $request->salary_range,
            'demand_status' => $request->demand_status,
            'skills' => $skillsArr,
            'certifications' => $certsArr,
            'projects' => array_values($projectsArr),
            'roadmap' => array_values($roadmapArr),
            'swot' => $swot,
        ]);

        return redirect()->route('admin.careers.index')
            ->with('success', 'Career Path created successfully.');
    }

    public function show(CareerPath $career)
    {
        return view('admin.careers.show', compact('career'));
    }

    public function edit(CareerPath $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, CareerPath $career)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'salary_range' => ['required', 'string'],
            'demand_status' => ['required', 'string'],
            'skills' => ['required', 'string'],
            'certifications' => ['required', 'string'],
            'projects' => ['required', 'array'],
            'roadmap' => ['required', 'array'],
            'strengths' => ['required', 'array'],
            'weaknesses' => ['required', 'array'],
            'opportunities' => ['required', 'array'],
            'threats' => ['required', 'array'],
        ]);

        $skillsArr = array_map('trim', explode(',', $request->skills));
        $certsArr = array_map('trim', explode(',', $request->certifications));
        $projectsArr = array_filter(array_map('trim', $request->projects));
        $roadmapArr = array_filter(array_map('trim', $request->roadmap));

        $swot = [
            'strengths' => array_filter(array_map('trim', $request->strengths)),
            'weaknesses' => array_filter(array_map('trim', $request->weaknesses)),
            'opportunities' => array_filter(array_map('trim', $request->opportunities)),
            'threats' => array_filter(array_map('trim', $request->threats)),
        ];

        $career->update([
            'name' => $request->name,
            'description' => $request->description,
            'salary_range' => $request->salary_range,
            'demand_status' => $request->demand_status,
            'skills' => $skillsArr,
            'certifications' => $certsArr,
            'projects' => array_values($projectsArr),
            'roadmap' => array_values($roadmapArr),
            'swot' => $swot,
        ]);

        return redirect()->route('admin.careers.index')
            ->with('success', 'Career Path updated successfully.');
    }

    public function destroy(CareerPath $career)
    {
        $career->delete();

        return redirect()->route('admin.careers.index')
            ->with('success', 'Career Path deleted successfully.');
    }
}
