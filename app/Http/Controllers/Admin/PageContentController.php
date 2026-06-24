<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * Available pages and their readable labels.
     */
    public static function availablePages(): array
    {
        return [
            'home' => 'Home Page',
            'mp-profiles' => 'MP Profiles',
            'gov-sites' => 'Gov Sites',
            'our-team' => 'Our Team',
            'contact' => 'Contact',
        ];
    }

    /**
     * Available sections per page with their readable labels and field definitions.
     */
    public static function sectionDefinitions(): array
    {
        return [
            'home' => [
                'hero' => [
                    'label' => 'Hero Section',
                    'fields' => [
                        'badge' => ['label' => 'Badge Text', 'type' => 'text'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'title_highlight' => ['label' => 'Title Highlight (gradient text)', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'features' => [
                    'label' => 'Features Cards',
                    'repeatable' => true,
                    'item_fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                        'icon' => [
                            'label' => 'Icon',
                            'type' => 'select',
                            'options' => [
                                'document' => 'Document',
                                'scale' => 'Scale',
                                'chat' => 'Chat',
                                'dashboard' => 'Dashboard',
                                'kanban' => 'Kanban',
                                'compare' => 'Compare',
                            ],
                        ],
                        'color' => [
                            'label' => 'Color',
                            'type' => 'select',
                            'options' => [
                                'emerald' => 'Emerald',
                                'blue' => 'Blue',
                                'amber' => 'Amber',
                                'purple' => 'Purple',
                                'rose' => 'Rose',
                                'indigo' => 'Indigo',
                            ],
                        ],
                    ],
                ],
                'cta' => [
                    'label' => 'Call-to-Action Section',
                    'fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'seo' => [
                    'label' => 'SEO / Meta',
                    'fields' => [
                        'meta_title' => ['label' => 'Meta Title', 'type' => 'text'],
                        'meta_description' => ['label' => 'Meta Description', 'type' => 'textarea'],
                    ],
                ],
            ],
            'mp-profiles' => [
                'header' => [
                    'label' => 'Page Header',
                    'fields' => [
                        'badge' => ['label' => 'Badge Text', 'type' => 'text'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'members' => [
                    'label' => 'MP Members',
                    'repeatable' => true,
                    'item_fields' => [
                        'photo' => ['label' => 'Photo', 'type' => 'image'],
                        'name' => ['label' => 'Full Name', 'type' => 'text'],
                        'role' => ['label' => 'Role / Title', 'type' => 'text'],
                        'email' => ['label' => 'Email Address', 'type' => 'text'],
                        'constituency' => ['label' => 'Constituency', 'type' => 'text'],
                        'province' => ['label' => 'Province', 'type' => 'text'],
                        'bio' => ['label' => 'Biography / Details', 'type' => 'textarea', 'rows' => 3],
                    ],
                ],
            ],
            'gov-sites' => [
                'header' => [
                    'label' => 'Page Header',
                    'fields' => [
                        'badge' => ['label' => 'Badge Text', 'type' => 'text'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'provinces' => [
                    'label' => 'Province Listings',
                    'repeatable' => true,
                    'item_fields' => [
                        'photo' => ['label' => 'Flag / Emblem Photo', 'type' => 'image'],
                        'name' => ['label' => 'Province Name', 'type' => 'text'],
                        'abbreviation' => ['label' => 'Abbreviation', 'type' => 'text'],
                        'capital' => ['label' => 'Capital City', 'type' => 'text'],
                        'website_url' => ['label' => 'Website URL', 'type' => 'text'],
                        'youtube_url' => ['label' => 'YouTube URL', 'type' => 'text'],
                    ],
                ],
            ],
            'our-team' => [
                'header' => [
                    'label' => 'Page Header',
                    'fields' => [
                        'badge' => ['label' => 'Badge Text', 'type' => 'text'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'team_members' => [
                    'label' => 'Team Members',
                    'repeatable' => true,
                    'item_fields' => [
                        'photo' => ['label' => 'Photo', 'type' => 'image'],
                        'name' => ['label' => 'Full Name', 'type' => 'text'],
                        'role' => ['label' => 'Role / Title', 'type' => 'text'],
                        'email' => ['label' => 'Email Address', 'type' => 'text'],
                        'bio' => ['label' => 'Biography', 'type' => 'textarea', 'rows' => 3],
                    ],
                ],
            ],
            'contact' => [
                'header' => [
                    'label' => 'Page Header',
                    'fields' => [
                        'badge' => ['label' => 'Badge Text', 'type' => 'text'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'description' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
                'contact_info' => [
                    'label' => 'Contact Information',
                    'fields' => [
                        'email' => ['label' => 'Email Address', 'type' => 'text'],
                        'email_label' => ['label' => 'Email Label', 'type' => 'text'],
                        'location' => ['label' => 'Location Address', 'type' => 'textarea'],
                        'location_label' => ['label' => 'Location Label', 'type' => 'text'],
                        'phone' => ['label' => 'Phone Number', 'type' => 'text'],
                        'phone_label' => ['label' => 'Phone Label', 'type' => 'text'],
                        'quick_response_title' => ['label' => 'Quick Response Box Title', 'type' => 'text'],
                        'quick_response_text' => ['label' => 'Quick Response Box Text', 'type' => 'textarea'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Display a listing of pages with their content.
     */
    public function index(): View
    {
        $pages = static::availablePages();
        $pageContents = PageContent::all()->groupBy('page');

        return view('admin.page-contents.index', compact('pages', 'pageContents'));
    }

    /**
     * Show the form for editing a specific page section.
     */
    public function edit(string $page, string $section): View
    {
        $definitions = static::sectionDefinitions();
        $pages = static::availablePages();

        abort_unless(isset($definitions[$page][$section]), 404, 'Page or section not found.');

        $sectionDef = $definitions[$page][$section];
        $pageContent = PageContent::where('page', $page)
            ->where('section', $section)
            ->first();

        $content = $pageContent?->content ?? [];

        return view('admin.page-contents.edit', compact('page', 'section', 'sectionDef', 'pages', 'content'));
    }

    /**
     * Update the specified page section.
     */
    public function update(Request $request, string $page, string $section): RedirectResponse
    {
        $definitions = static::sectionDefinitions();
        abort_unless(isset($definitions[$page][$section]), 404, 'Page or section not found.');

        $sectionDef = $definitions[$page][$section];
        $fields = $sectionDef['fields'];
        $rules = [];
        foreach ($fields as $key => $field) {
            if (($field['type'] ?? 'text') === 'json_array') {
                $rules["content.{$key}"] = 'nullable|json';
            } else {
                $rules["content.{$key}"] = 'nullable|string';
            }
        }

        $validated = $request->validate($rules);

        // Decode JSON fields back to arrays for storage
        $content = $validated['content'] ?? [];
        foreach ($fields as $key => $field) {
            if (($field['type'] ?? 'text') === 'json_array' && isset($content[$key]) && is_string($content[$key])) {
                $content[$key] = json_decode($content[$key], true);
            }
        }

        PageContent::updateOrCreate(
            ['page' => $page, 'section' => $section],
            [
                'content' => $content,
                'is_active' => true,
                'sort_order' => array_search($section, array_keys($definitions[$page])) + 1,
            ]
        );

        $pages = static::availablePages();

        return redirect()->route('admin.page-contents.index')
            ->with('status', ($pages[$page] ?? $page) . ' — ' . ($sectionDef['label'] ?? $section) . ' updated successfully.');
    }
}
