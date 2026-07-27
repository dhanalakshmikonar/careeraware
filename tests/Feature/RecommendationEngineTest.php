<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\CareerPath;
use App\Models\AssessmentResponse;
use App\Services\RecommendationEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecommendationEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_recommendation_engine_calculates_correct_confidence()
    {
        // 1. Seed necessary careers
        $ai = CareerPath::create([
            'code' => 'AI',
            'name' => 'AI Engineer',
            'description' => 'AI desc',
            'salary_range' => '$100k',
            'demand_status' => 'High',
            'skills' => ['Python'],
            'certifications' => ['AI Cert'],
            'projects' => ['AI Project'],
            'roadmap' => ['Step 1'],
            'swot' => ['strengths' => [], 'weaknesses' => [], 'opportunities' => [], 'threats' => []],
        ]);

        $cloud = CareerPath::create([
            'code' => 'Cloud',
            'name' => 'Cloud Architect',
            'description' => 'Cloud desc',
            'salary_range' => '$90k',
            'demand_status' => 'High',
            'skills' => ['AWS'],
            'certifications' => ['Cloud Cert'],
            'projects' => ['Cloud Project'],
            'roadmap' => ['Step 1'],
            'swot' => ['strengths' => [], 'weaknesses' => [], 'opportunities' => [], 'threats' => []],
        ]);

        // 2. Create questions and options
        $q1 = Question::create([
            'question_text' => 'Question 1 Scenario',
            'category' => 'Problem Solving',
        ]);

        $o1_1 = QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Option A (favors AI)',
            'career_weights' => ['AI' => 5, 'Cloud' => 1],
        ]);

        $o1_2 = QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Option B (favors Cloud)',
            'career_weights' => ['AI' => 1, 'Cloud' => 5],
        ]);

        $q2 = Question::create([
            'question_text' => 'Question 2 Scenario',
            'category' => 'Work Style',
        ]);

        $o2_1 = QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Option A (favors AI heavy)',
            'career_weights' => ['AI' => 4, 'Cloud' => 0],
        ]);

        $o2_2 = QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Option B (favors Cloud heavy)',
            'career_weights' => ['AI' => 0, 'Cloud' => 4],
        ]);

        // Max possible scores:
        // AI: q1 (5) + q2 (4) = 9
        // Cloud: q1 (5) + q2 (4) = 9

        // 3. Create a student user
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        // 4. Save responses (Student selects Option 1 for q1, and Option 1 for q2)
        // This gives AI: 5 + 4 = 9 points (100% confidence)
        // This gives Cloud: 1 + 0 = 1 point (11.1% confidence)
        AssessmentResponse::create([
            'user_id' => $student->id,
            'question_id' => $q1->id,
            'question_option_id' => $o1_1->id,
        ]);

        AssessmentResponse::create([
            'user_id' => $student->id,
            'question_id' => $q2->id,
            'question_option_id' => $o2_1->id,
        ]);

        // 5. Run recommendation engine
        $engine = new RecommendationEngine();
        $results = $engine->calculate($student->id);

        // 6. Assertions
        $this->assertArrayHasKey('top_careers', $results);
        $this->assertArrayHasKey('career_scores', $results);

        $top = $results['top_careers'];
        $this->assertCount(2, $top); // Only seeded 2 careers

        // Top career should be AI
        $this->assertEquals('AI', $top[0]['code']);
        $this->assertEquals(100.0, $top[0]['confidence']);

        // Second career should be Cloud
        $this->assertEquals('Cloud', $top[1]['code']);
        $this->assertEquals(11.1, $top[1]['confidence']);
    }
}
