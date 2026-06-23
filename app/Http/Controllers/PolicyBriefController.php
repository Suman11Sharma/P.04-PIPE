<?php

namespace App\Http\Controllers;

use App\Models\PolicyBrief;

class PolicyBriefController extends Controller
{
    /**
     * Display a single published policy brief with the reading layout.
     */
    public function show(string $slug)
    {
        $brief = PolicyBrief::query()
            ->published()
            ->where('slug', $slug)
            ->with(['sector', 'compiler', 'verifier'])
            ->firstOrFail();

        // Increment view count
        $brief->increment('views_count');

        // Load the user's existing feedback on this brief (if any)
        $existingFeedback = null;
        if (auth()->check()) {
            $existingFeedback = $brief->feedback()
                ->where('user_id', auth()->id())
                ->first();
        }

        // Compute related briefs from the same sector
        $relatedBriefs = PolicyBrief::query()
            ->published()
            ->where('id', '!=', $brief->id)
            ->where('sector_id', $brief->sector_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('policy-briefs.show', compact(
            'brief',
            'existingFeedback',
            'relatedBriefs'
        ));
    }
}
