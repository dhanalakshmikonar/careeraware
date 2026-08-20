<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Stream a CSV export of all students and their top career recommendation.
     */
    public function exportStudentsCsv(): StreamedResponse
    {
        $students = User::where('role', 'student')->with('results')->orderBy('name')->get();

        $filename = 'students_export_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () use ($students) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Name', 'Email', 'Mobile Number', 'Department', 'Registered On', 'Top Career', 'Confidence (%)', 'Assessment Status']);

            foreach ($students as $student) {
                $result = $student->results->sortByDesc('created_at')->first();
                $topCareer = $result->top_careers[0] ?? null;

                fputcsv($handle, [
                    $student->name,
                    $student->email,
                    $student->phone ?? 'N/A',
                    $student->department ?? 'Other',
                    $student->created_at->format('Y-m-d'),
                    $topCareer['name'] ?? '',
                    $topCareer['confidence'] ?? '',
                    $result ? 'Completed' : 'Not Attempted',
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Download the authenticated student's latest career report as an HTML file.
     */
    public function downloadReport(): StreamedResponse
    {
        $user = Auth::user();

        $result = AssessmentResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->firstOrFail();

        $filename = 'career_report_' . now()->format('Y_m_d_His') . '.html';

        $html = view('student.results_report', [
            'student' => $user,
            'result' => $result,
        ])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
