<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Home Page ──────────────────────────────────────────
        PageContent::updateOrCreate(
            ['page' => 'home', 'section' => 'hero'],
            [
                'content' => [
                    'badge' => 'Province Information Portal',
                    'title' => 'Empowering Citizens',
                    'title_highlight' => 'PIPE',
                    'description' => 'Province Information Portal and Engagement Platform — connecting citizens with provincial government data, real-time legislative tracking, and community engagement tools. Part of the Pokhara Research Centre.',
                ],
                'sort_order' => 1,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'home', 'section' => 'features'],
            [
                'content' => [
                    'items' => [
                        [
                            'title' => 'Policy Briefs',
                            'description' => 'Curated expert briefings across 10 policy sectors with rich markdown content, executive summaries, and an MP feedback engine.',
                            'icon' => 'document',
                            'color' => 'emerald',
                        ],
                        [
                            'title' => 'Legislative Tracker',
                            'description' => 'Real-time bill progress with multi-stage steppers, side-by-side amendment comparison with diff highlighting.',
                            'icon' => 'scale',
                            'color' => 'blue',
                        ],
                        [
                            'title' => 'Ask-An-Expert',
                            'description' => 'Submit research queries with tiered turnaround options: Standard, 48-Hour Deep Analysis, or 30-Minute Floor Support.',
                            'icon' => 'chat',
                            'color' => 'amber',
                        ],
                        [
                            'title' => 'Personal Dashboard',
                            'description' => 'Personalized MP workspace with intelligence feed, query tracking, upcoming legislation, and policy risk alerts.',
                            'icon' => 'dashboard',
                            'color' => 'purple',
                        ],
                        [
                            'title' => 'Researcher Kanban',
                            'description' => 'Internal workflow management with SLA monitoring, senior review workflows, and automated breach detection.',
                            'icon' => 'kanban',
                            'color' => 'rose',
                        ],
                        [
                            'title' => 'Bill Comparison',
                            'description' => 'Side-by-side amendment delta with color-coded diff highlighting, constitutional summaries, and voting ledger charts.',
                            'icon' => 'compare',
                            'color' => 'indigo',
                        ],
                    ],
                ],
                'sort_order' => 2,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'home', 'section' => 'cta'],
            [
                'content' => [
                    'title' => 'Ready to engage with provincial intelligence?',
                    'description' => "Join South Africa's leading provincial information portal connecting citizens with government data and engagement tools.",
                ],
                'sort_order' => 2,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'home', 'section' => 'seo'],
            [
                'content' => [
                    'meta_title' => 'PIPE — Province Information Portal and Engagement Platform',
                    'meta_description' => 'Province Information Portal and Engagement Platform — connecting citizens with provincial government data, legislative tracking, and community engagement. Part of the Pokhara Research Centre.',
                ],
                'sort_order' => 3,
            ]
        );

        // ── MP Profiles Page ────────────────────────────────────
        PageContent::updateOrCreate(
            ['page' => 'mp-profiles', 'section' => 'header'],
            [
                'content' => [
                    'badge' => 'Parliament',
                    'title' => 'Member of Parliament Profiles',
                    'description' => 'Meet the parliamentary members serving their constituencies through the Province Information Portal and Engagement Platform — a Pokhara Research Centre initiative.',
                ],
                'sort_order' => 1,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'mp-profiles', 'section' => 'members'],
            [
                'content' => [
                    'items' => [
                        [
                            'name' => 'Hon. John Dlamini',
                            'role' => 'Member of Parliament — Finance Committee',
                            'email' => 'john.dlamini@parliament.gov.za',
                            'constituency' => 'Umlazi Central',
                            'province' => 'KwaZulu-Natal',
                            'bio' => 'Serving his second term as MP. Previously served as Deputy Chair of the Portfolio Committee on Finance. Advocates for fiscal transparency and inclusive economic growth.',
                        ],
                        [
                            'name' => 'Hon. Mary Ndlovu',
                            'role' => 'Committee Chair — Health',
                            'email' => 'mary.ndlovu@parliament.gov.za',
                            'constituency' => 'Soweto East',
                            'province' => 'Gauteng',
                            'bio' => 'Chairs the Portfolio Committee on Health. Former provincial health MEC with extensive experience in public healthcare policy and National Health Insurance implementation.',
                        ],
                        [
                            'name' => 'Hon. Peter Mokwena',
                            'role' => 'Member of Parliament — Education',
                            'email' => 'peter.mokwena@parliament.gov.za',
                            'constituency' => 'Mafikeng North',
                            'province' => 'North West',
                            'bio' => 'MP focused on basic education reform and skills development. Leads the parliamentary caucus on early childhood development.',
                        ],
                        [
                            'name' => 'Hon. Grace Zulu',
                            'role' => 'Member of Parliament — Agriculture',
                            'email' => 'grace.zulu@parliament.gov.za',
                            'constituency' => 'Ermelo South',
                            'province' => 'Mpumalanga',
                            'bio' => 'Former agricultural economist representing farming communities. Advocates for land reform, smallholder farmer support, and sustainable agriculture policies.',
                        ],
                        [
                            'name' => 'Hon. Thabo Mokoena',
                            'role' => 'Member of Parliament — Justice',
                            'email' => 'thabo.mokoena@parliament.gov.za',
                            'constituency' => 'Bloemfontein Central',
                            'province' => 'Free State',
                            'bio' => 'Legal scholar and human rights advocate. Serves on the Portfolio Committee on Justice and Correctional Services. Previously a constitutional law professor.',
                        ],
                        [
                            'name' => 'Hon. Lerato Molefe',
                            'role' => 'Member of Parliament — Environment',
                            'email' => 'lerato.molefe@parliament.gov.za',
                            'constituency' => 'Polokwane West',
                            'province' => 'Limpopo',
                            'bio' => 'Environmental policy specialist focused on climate change adaptation, renewable energy transition, and conservation legislation. Represents mining-affected communities.',
                        ],
                    ],
                ],
                'sort_order' => 2,
            ]
        );

        // ── Gov Sites Page ──────────────────────────────────────
        PageContent::updateOrCreate(
            ['page' => 'gov-sites', 'section' => 'header'],
            [
                'content' => [
                    'badge' => 'South Africa',
                    'title' => 'Provincial Government Sites',
                    'description' => "Official websites and social channels for South Africa's provincial governments — part of the Pokhara Research Centre network.",
                ],
                'sort_order' => 1,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'gov-sites', 'section' => 'provinces'],
            [
                'content' => [
                    'items' => [
                        [
                            'name' => 'Eastern Cape',
                            'abbreviation' => 'EC',
                            'capital' => 'Bhisho',
                            'website_url' => 'https://www.ecprov.gov.za',
                            'youtube_url' => 'https://youtube.com/@EasternCapeProvince',
                        ],
                        [
                            'name' => 'Gauteng',
                            'abbreviation' => 'GP',
                            'capital' => 'Johannesburg',
                            'website_url' => 'https://www.gauteng.gov.za',
                            'youtube_url' => 'https://youtube.com/@GautengProvince',
                        ],
                        [
                            'name' => 'KwaZulu-Natal',
                            'abbreviation' => 'KZN',
                            'capital' => 'Pietermaritzburg',
                            'website_url' => 'https://www.kzn.gov.za',
                            'youtube_url' => 'https://youtube.com/@KZNProvince',
                        ],
                        [
                            'name' => 'Limpopo',
                            'abbreviation' => 'LP',
                            'capital' => 'Polokwane',
                            'website_url' => 'https://www.limpopo.gov.za',
                            'youtube_url' => 'https://youtube.com/@LimpopoProvince',
                        ],
                        [
                            'name' => 'Western Cape',
                            'abbreviation' => 'WC',
                            'capital' => 'Cape Town',
                            'website_url' => 'https://www.westerncape.gov.za',
                            'youtube_url' => 'https://youtube.com/@WesternCapeGov',
                        ],
                        [
                            'name' => 'Free State',
                            'abbreviation' => 'FS',
                            'capital' => 'Bloemfontein',
                            'website_url' => 'https://www.freestate.gov.za',
                            'youtube_url' => 'https://youtube.com/@FreeStateProvince',
                        ],
                        [
                            'name' => 'Mpumalanga',
                            'abbreviation' => 'MP',
                            'capital' => 'Mbombela',
                            'website_url' => 'https://www.mpumalanga.gov.za',
                            'youtube_url' => 'https://youtube.com/@MpumalangaProvince',
                        ],
                        [
                            'name' => 'North West',
                            'abbreviation' => 'NW',
                            'capital' => 'Mahikeng',
                            'website_url' => 'https://www.nwpg.gov.za',
                            'youtube_url' => 'https://youtube.com/@NorthWestProvince',
                        ],
                        [
                            'name' => 'Northern Cape',
                            'abbreviation' => 'NC',
                            'capital' => 'Kimberley',
                            'website_url' => 'https://www.northerncape.gov.za',
                            'youtube_url' => 'https://youtube.com/@NorthernCapeProvince',
                        ],
                    ],
                ],
                'sort_order' => 2,
            ]
        );

        // ── Our Team Page ───────────────────────────────────────
        PageContent::updateOrCreate(
            ['page' => 'our-team', 'section' => 'header'],
            [
                'content' => [
                    'badge' => 'Team',
                    'title' => 'Our Team',
                    'description' => 'The people behind PIPE — a Pokhara Research Centre initiative connecting citizens with provincial information, data, and engagement tools.',
                ],
                'sort_order' => 1,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'our-team', 'section' => 'team_members'],
            [
                'content' => [
                    'items' => [
                        [
                            'name' => 'Dr. Thabo Mbeki',
                            'role' => 'Senior Policy Researcher',
                            'email' => 'thabo.mbeki@pipe.gov',
                            'bio' => 'Leading policy analysis with over 15 years of experience in legislative research and constitutional law. Former advisor to the Portfolio Committee on Finance.',
                        ],
                        [
                            'name' => 'Sarah Khumalo',
                            'role' => 'Research Director',
                            'email' => 'sarah.khumalo@pipe.gov',
                            'bio' => 'Oversees the research division and coordinates expert briefings across all policy sectors. Specializes in economic policy and public finance.',
                        ],
                        [
                            'name' => 'James Ndlovu',
                            'role' => 'Junior Researcher',
                            'email' => 'james.ndlovu@pipe.gov',
                            'bio' => 'Junior researcher focusing on environmental policy and climate change legislation. Supports senior researchers with data analysis and brief preparation.',
                        ],
                        [
                            'name' => 'Priya Patel',
                            'role' => 'Data Analyst',
                            'email' => 'priya.patel@pipe.gov',
                            'bio' => 'Transforms complex legislative data into actionable insights. Manages the bill tracking system and produces visual analytics for parliamentary committees.',
                        ],
                        [
                            'name' => 'Michael Okafor',
                            'role' => 'Senior Researcher — Health',
                            'email' => 'michael.okafor@pipe.gov',
                            'bio' => 'Specialist in health policy and public healthcare legislation. Provides expert briefings on the National Health Insurance Bill and related reforms.',
                        ],
                        [
                            'name' => 'Lindiwe Dlamini',
                            'role' => 'Junior Researcher — Education',
                            'email' => 'lindiwe.dlamini@pipe.gov',
                            'bio' => 'Researcher focused on education policy, skills development, and youth empowerment legislation. Assists with brief preparation and stakeholder consultation.',
                        ],
                    ],
                ],
                'sort_order' => 2,
            ]
        );

        // ── Contact Page ────────────────────────────────────────
        PageContent::updateOrCreate(
            ['page' => 'contact', 'section' => 'header'],
            [
                'content' => [
                    'badge' => 'Get in touch',
                    'title' => 'Contact Us',
                    'description' => 'Have a question, suggestion, or need assistance? Reach out to the PIPE team — part of the Pokhara Research Centre.',
                ],
                'sort_order' => 1,
            ]
        );

        PageContent::updateOrCreate(
            ['page' => 'contact', 'section' => 'contact_info'],
            [
                'content' => [
                    'email' => 'contact@pipe.gov',
                    'email_label' => 'Email',
                    'location' => "Parliament of South Africa\nCape Town, Western Cape",
                    'location_label' => 'Location',
                    'phone' => '+27 21 400 0000',
                    'phone_label' => 'Phone',
                    'quick_response_title' => 'Quick Response',
                    'quick_response_text' => 'Our team typically responds within 24 hours. For urgent enquiries, please use the Ask-An-Expert system.',
                ],
                'sort_order' => 2,
            ]
        );
    }
}
