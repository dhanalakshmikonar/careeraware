<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\CareerPath;
use App\Models\AssessmentResponse;
use Illuminate\Support\Collection;

class RecommendationEngine
{
    /**
     * Calculate recommendations for a student user within a session.
     *
     * @param int $userId
     * @param int|null $awarenessSessionId
     * @return array
     */
    public function calculate(int $userId, ?int $awarenessSessionId = null): array
    {
        // 1. Get all questions and options to compute the maximum possible score for each career
        $allQuestions = Question::with('options')->get();
        
        $maxScores = [];
        $careerCodes = CareerPath::pluck('code')->toArray();

        foreach ($careerCodes as $code) {
            $maxScores[$code] = 0;
        }

        // Calculate max potential score for each career
        foreach ($allQuestions as $question) {
            $questionMaxs = [];
            foreach ($careerCodes as $code) {
                $questionMaxs[$code] = 0;
            }

            foreach ($question->options as $option) {
                $weights = $option->career_weights ?? [];
                foreach ($weights as $code => $weight) {
                    if (in_array($code, $careerCodes)) {
                        $questionMaxs[$code] = max($questionMaxs[$code], (float) $weight);
                    }
                }
            }

            foreach ($careerCodes as $code) {
                $maxScores[$code] += $questionMaxs[$code];
            }
        }

        // 2. Fetch the student's selected options/responses
        $responses = AssessmentResponse::where('user_id', $userId)
            ->where('awareness_session_id', $awarenessSessionId)
            ->with('option')
            ->get();

        $studentScores = [];
        foreach ($careerCodes as $code) {
            $studentScores[$code] = 0;
        }

        // Sum weights from chosen options
        foreach ($responses as $response) {
            if ($response->option) {
                $weights = $response->option->career_weights ?? [];
                foreach ($weights as $code => $weight) {
                    if (in_array($code, $careerCodes)) {
                        $studentScores[$code] += (float) $weight;
                    }
                }
            }
        }

        // 3. Compute confidence percentages and compile list
        $recommendations = [];
        foreach ($careerCodes as $code) {
            $max = $maxScores[$code];
            $score = $studentScores[$code];
            
            $confidence = $max > 0 ? ($score / $max) * 100 : 0;
            
            $recommendations[] = [
                'code' => $code,
                'score' => $score,
                'max_possible' => $max,
                'confidence' => round($confidence, 1)
            ];
        }

        // 4. Sort by confidence percentage descending, then by score descending
        usort($recommendations, function ($a, $b) {
            if ($b['confidence'] === $a['confidence']) {
                return $b['score'] <=> $a['score'];
            }
            return $b['confidence'] <=> $a['confidence'];
        });

        // 5. Hydrate the top 3 with actual CareerPath models
        $top3 = array_slice($recommendations, 0, 3);
        $top3Hydrated = [];

        foreach ($top3 as $rec) {
            $careerPath = CareerPath::where('code', $rec['code'])->first();
            if ($careerPath) {
                $top3Hydrated[] = [
                    'code' => $rec['code'],
                    'name' => $careerPath->name,
                    'description' => $careerPath->description,
                    'confidence' => $rec['confidence'],
                    'skills' => $careerPath->skills,
                    'certifications' => $careerPath->certifications,
                    'projects' => $careerPath->projects,
                    'salary_range' => $careerPath->salary_range,
                    'demand_status' => $careerPath->demand_status,
                    'roadmap' => $careerPath->roadmap,
                    'swot' => $careerPath->swot,
                ];
            }
        }

        return [
            'top_careers' => $top3Hydrated,
            'career_scores' => $studentScores,
        ];
    }
}
