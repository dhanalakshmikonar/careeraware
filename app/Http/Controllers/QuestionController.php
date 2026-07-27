<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\CareerPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('options')
            ->orderBy('category')
            ->paginate(15);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $careers = CareerPath::all();
        $categories = [
            'Work Style', 'Problem Solving', 'Learning Style', 
            'Technology Interest', 'Creativity', 'Leadership', 
            'Communication', 'Analytical Thinking', 'Curiosity'
        ];

        return view('admin.questions.create', compact('careers', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_text' => ['required', 'string'],
            'category' => ['required', 'string'],
            'options' => ['required', 'array', 'size:4'],
            'options.*.text' => ['required', 'string'],
            'options.*.weights' => ['nullable', 'array'],
        ]);

        DB::transaction(function() use ($request) {
            $question = Question::create([
                'question_text' => $request->question_text,
                'category' => $request->category,
            ]);

            foreach ($request->options as $optData) {
                // Filter out zero weights to keep JSON clean
                $weights = array_filter($optData['weights'] ?? [], function($val) {
                    return $val !== null && $val !== '' && (float)$val > 0;
                });

                // Cast weight values to floats
                $weights = array_map('floatval', $weights);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optData['text'],
                    'career_weights' => $weights,
                ]);
            }
        });

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question and options created successfully.');
    }

    public function edit(Question $question)
    {
        $question->load('options');
        $careers = CareerPath::all();
        $categories = [
            'Work Style', 'Problem Solving', 'Learning Style', 
            'Technology Interest', 'Creativity', 'Leadership', 
            'Communication', 'Analytical Thinking', 'Curiosity'
        ];

        return view('admin.questions.edit', compact('question', 'careers', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => ['required', 'string'],
            'category' => ['required', 'string'],
            'options' => ['required', 'array', 'size:4'],
            'options.*.id' => ['required', 'exists:question_options,id'],
            'options.*.text' => ['required', 'string'],
            'options.*.weights' => ['nullable', 'array'],
        ]);

        DB::transaction(function() use ($request, $question) {
            $question->update([
                'question_text' => $request->question_text,
                'category' => $request->category,
            ]);

            foreach ($request->options as $optData) {
                $option = QuestionOption::findOrFail($optData['id']);

                // Filter out zero/null weights
                $weights = array_filter($optData['weights'] ?? [], function($val) {
                    return $val !== null && $val !== '' && (float)$val > 0;
                });
                
                $weights = array_map('floatval', $weights);

                $option->update([
                    'option_text' => $optData['text'],
                    'career_weights' => $weights,
                ]);
            }
        });

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question and options updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete(); // Cascades to options in DB

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question deleted successfully.');
    }
}
