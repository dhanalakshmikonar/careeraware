<?php

namespace App\Services;

use App\Models\Question;
use App\Models\CareerPath;
use App\Models\AssessmentResponse;

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
        $careerPaths = CareerPath::get()->keyBy('code');
        $maxScores = [];
        $careerCodes = $careerPaths->keys()->all();
        $careerCodeLookup = array_fill_keys($careerCodes, true);
        $scoreableQuestions = array_fill_keys($careerCodes, 0);

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
                    if (isset($careerCodeLookup[$code])) {
                        $questionMaxs[$code] = max($questionMaxs[$code], (float) $weight);
                    }
                }
            }

            foreach ($careerCodes as $code) {
                $maxScores[$code] += $questionMaxs[$code];
                if ($questionMaxs[$code] > 0) {
                    $scoreableQuestions[$code]++;
                }
            }
        }

        // 2. Fetch the student's selected options/responses
        $responses = AssessmentResponse::where('user_id', $userId)
            ->where('awareness_session_id', $awarenessSessionId)
            ->with('option')
            ->get();

        $studentScores = [];
        $supportingAnswers = array_fill_keys($careerCodes, 0);
        foreach ($careerCodes as $code) {
            $studentScores[$code] = 0;
        }

        // Sum weights from chosen options
        foreach ($responses as $response) {
            if ($response->option) {
                $weights = $response->option->career_weights ?? [];
                foreach ($weights as $code => $weight) {
                    if (isset($careerCodeLookup[$code])) {
                        $studentScores[$code] += (float) $weight;
                        if ((float) $weight > 0) {
                            $supportingAnswers[$code]++;
                        }
                    }
                }
            }
        }

        // 3. Compute normalized assessment-fit percentages and evidence details.
        // The percentage means "score earned / the score this questionnaire makes
        // available for this path". It is deliberately not presented as a prediction
        // of future job performance or career success.
        $recommendations = [];
        $answeredQuestions = $responses->pluck('question_id')->unique()->count();
        $totalQuestions = $allQuestions->count();
        foreach ($careerCodes as $code) {
            $max = $maxScores[$code];
            $score = $studentScores[$code];
            
            $confidence = $max > 0 ? ($score / $max) * 100 : 0;
            
            $recommendations[] = [
                'code' => $code,
                'score' => $score,
                'max_possible' => $max,
                'confidence' => round($confidence, 1),
                'answered_questions' => $answeredQuestions,
                'total_questions' => $totalQuestions,
                'supporting_answers' => $supportingAnswers[$code],
                'scoreable_questions' => $scoreableQuestions[$code],
            ];
        }

        // 4. Sort by confidence percentage descending, then by score descending
        usort($recommendations, function ($a, $b) {
            if ($b['confidence'] === $a['confidence']) {
                return $b['score'] <=> $a['score'];
            }
            return $b['confidence'] <=> $a['confidence'];
        });

        // Add the lead over the next ranked path. This makes close rankings clear
        // instead of overstating certainty when two paths are nearly tied.
        foreach ($recommendations as $index => &$recommendation) {
            $nextConfidence = $recommendations[$index + 1]['confidence'] ?? 0;
            $recommendation['ranking_margin'] = round($recommendation['confidence'] - $nextConfidence, 1);
        }
        unset($recommendation);

        // 5. Hydrate the top 3 with actual CareerPath models
        $top3 = array_slice($recommendations, 0, 3);
        $top3Hydrated = [];

        foreach ($top3 as $rec) {
            $careerPath = $careerPaths->get($rec['code']);
            if ($careerPath) {
                $top3Hydrated[] = [
                    'code' => $rec['code'],
                    'name' => $careerPath->name,
                    'description' => $careerPath->description,
                    'confidence' => $rec['confidence'],
                    'score' => $rec['score'],
                    'max_possible' => $rec['max_possible'],
                    'answered_questions' => $rec['answered_questions'],
                    'total_questions' => $rec['total_questions'],
                    'supporting_answers' => $rec['supporting_answers'],
                    'scoreable_questions' => $rec['scoreable_questions'],
                    'ranking_margin' => $rec['ranking_margin'],
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
