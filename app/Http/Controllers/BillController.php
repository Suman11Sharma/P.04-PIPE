<?php

namespace App\Http\Controllers;

use App\Models\Bill;

class BillController extends Controller
{
    /**
     * Show the global bills tracker directory.
     */
    public function index()
    {
        return view('bills.index');
    }

    /**
     * Display the side-by-side bill delta and comparison page.
     */
    public function show(string $slug)
    {
        // Use local_identifier as the slug identifier for route-model binding
        $bill = Bill::query()
            ->where('local_identifier', $slug)
            ->with(['amendments' => function ($q) {
                $q->with('proposer')->latest('version');
            }])
            ->firstOrFail();

        // Decode the comparison_matrix into a structured diff view
        $comparisonMatrix = $bill->comparison_matrix;

        // Compute structured diff data from the latest amendment or comparison_matrix
        $diffData = $this->buildDiffData($bill, $comparisonMatrix);

        // Voting ledger data for the chart
        $votingLedger = $bill->voting_records ?? [];

        return view('bills.show', compact(
            'bill',
            'comparisonMatrix',
            'diffData',
            'votingLedger'
        ));
    }

    /**
     * Build structured diff data from the bill's amendment history.
     *
     * Returns an array of sections, each with 'original' and 'amended' text
     * and a 'type' (added, removed, modified, unchanged).
     */
    protected function buildDiffData(Bill $bill, ?array $comparisonMatrix): array
    {
        // If the comparison_matrix has structured section-by-section data, use it
        if ($comparisonMatrix && isset($comparisonMatrix['sections'])) {
            return $comparisonMatrix['sections'];
        }

        // If there's a flat original/amended model, build sections from it
        $latestAmendment = $bill->amendments()->first();

        if ($latestAmendment && $latestAmendment->original_text && $latestAmendment->amended_text) {
            return $this->computeSectionDiff(
                $latestAmendment->original_text,
                $latestAmendment->amended_text
            );
        }

        // Fallback: use the bill's stage description as pseudo-content
        $currentDescription = $bill->current_stage_description ?? 'No bill text available.';
        $constitutionalSummary = $bill->constitutional_implications_summary;

        return [
            [
                'section' => 'Bill Overview',
                'original' => $currentDescription,
                'amended' => $currentDescription,
                'type' => 'unchanged',
            ],
        ];
    }

    /**
     * Simple line-based diff between two text strings.
     * Returns an array of section blocks suitable for the comparison view.
     */
    protected function computeSectionDiff(string $original, string $amended): array
    {
        $origLines = explode("\n", $original);
        $amendLines = explode("\n", $amended);

        $sections = [];
        $maxLines = max(count($origLines), count($amendLines));

        for ($i = 0; $i < $maxLines; $i++) {
            $origLine = $origLines[$i] ?? '';
            $amendLine = $amendLines[$i] ?? '';

            if ($origLine === $amendLine) {
                $sections[] = [
                    'section' => 'Line ' . ($i + 1),
                    'original' => $origLine,
                    'amended' => $amendLine,
                    'type' => 'unchanged',
                ];
            } elseif (empty(trim($origLine))) {
                $sections[] = [
                    'section' => 'Line ' . ($i + 1),
                    'original' => '',
                    'amended' => $amendLine,
                    'type' => 'added',
                ];
            } elseif (empty(trim($amendLine))) {
                $sections[] = [
                    'section' => 'Line ' . ($i + 1),
                    'original' => $origLine,
                    'amended' => '',
                    'type' => 'removed',
                ];
            } else {
                $sections[] = [
                    'section' => 'Line ' . ($i + 1),
                    'original' => $origLine,
                    'amended' => $amendLine,
                    'type' => 'modified',
                ];
            }
        }

        return $sections;
    }
}
