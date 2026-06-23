<?php

namespace Database\Seeders;

use App\Enums\BillStatus;
use App\Enums\BriefStatus;
use App\Enums\QueryStatus;
use App\Enums\TurnaroundTier;
use App\Enums\UrgencyLevel;
use App\Enums\UserRole;
use App\Models\Bill;
use App\Models\BillAmendment;
use App\Models\Constituency;
use App\Models\ExpertQuery;
use App\Models\PolicyBrief;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ═══════════════════════════════════════════════════════════════
        // USERS
        // ═══════════════════════════════════════════════════════════════
        $admin = User::factory()->withRole(UserRole::Admin)->create([
            'name' => 'System Administrator', 'email' => 'admin@pipe.gov',
        ]);
        $seniorResearcher = User::factory()->withRole(UserRole::SeniorResearcher)->create([
            'name' => 'Dr. Sarah Chen', 'email' => 'sarah.chen@pipe.gov',
        ]);
        $juniorResearcher = User::factory()->withRole(UserRole::JuniorResearcher)->create([
            'name' => 'James Mwangi', 'email' => 'james.mwangi@pipe.gov',
        ]);
        $committeeChair = User::factory()->withRole(UserRole::CommitteeChair)->create([
            'name' => 'Hon. Elizabeth Nkosi', 'email' => 'elizabeth.nkosi@pipe.gov',
        ]);
        $mp = User::factory()->withRole(UserRole::MP)->create([
            'name' => 'Hon. David Ochieng', 'email' => 'david.ochieng@pipe.gov',
        ]);
        $staff = User::factory()->withRole(UserRole::Staff)->create([
            'name' => 'Grace Akinyi', 'email' => 'grace.akinyi@pipe.gov',
        ]);

        $users = compact('admin', 'seniorResearcher', 'juniorResearcher', 'committeeChair', 'mp', 'staff');

        // ═══════════════════════════════════════════════════════════════
        // PROVINCES & CONSTITUENCIES
        // ═══════════════════════════════════════════════════════════════
        $provinces = [
            'Eastern Cape' => ['Bhisho', 'Mthatha', 'Gqeberha', 'East London'],
            'Gauteng' => ['Johannesburg Central', 'Tshwane', 'Ekurhuleni', 'Sedibeng'],
            'Western Cape' => ['Cape Town Central', 'Stellenbosch', 'George', 'West Coast'],
            'KwaZulu-Natal' => ['eThekwini', 'uMgungundlovu', 'King Cetshwayo', 'Umkhanyakude'],
            'Limpopo' => ['Polokwane', 'Sekhukhune', 'Mopani', 'Vhembe'],
        ];

        $constituencies = [];
        foreach ($provinces as $province => $constituencyNames) {
            foreach ($constituencyNames as $name) {
                $constituencies[] = Constituency::create([
                    'name' => $name,
                    'province_name' => $province,
                    'socio_economic_indicators' => [
                        'population' => rand(200000, 1500000),
                        'unemployment_rate' => round(rand(200, 450) / 10, 1),
                        'gdp_per_capita' => rand(5000, 25000),
                        'literacy_rate' => round(rand(700, 980) / 10, 1),
                        'primary_industries' => ['Agriculture', 'Manufacturing', 'Services'],
                    ],
                ]);
            }
        }

        // Assign constituencies to MP and Committee Chair
        $mp->constituency_id = $constituencies[0]->id;
        $mp->save();
        $committeeChair->constituency_id = $constituencies[5]->id;
        $committeeChair->save();

        // ═══════════════════════════════════════════════════════════════
        // SECTORS
        // ═══════════════════════════════════════════════════════════════
        $sectorData = [
            ['name' => 'Health', 'slug' => 'health', 'icon_class' => 'heart-pulse'],
            ['name' => 'Macroeconomics', 'slug' => 'macroeconomics', 'icon_class' => 'chart-line'],
            ['name' => 'Infrastructure', 'slug' => 'infrastructure', 'icon_class' => 'building-bridge'],
            ['name' => 'Energy', 'slug' => 'energy', 'icon_class' => 'bolt'],
            ['name' => 'Education', 'slug' => 'education', 'icon_class' => 'academic-cap'],
            ['name' => 'Agriculture', 'slug' => 'agriculture', 'icon_class' => 'sprout'],
            ['name' => 'Defence & Security', 'slug' => 'defence', 'icon_class' => 'shield-check'],
            ['name' => 'Trade & Industry', 'slug' => 'trade', 'icon_class' => 'truck'],
            ['name' => 'Environment & Climate', 'slug' => 'environment', 'icon_class' => 'globe-alt'],
            ['name' => 'Digital Economy', 'slug' => 'digital-economy', 'icon_class' => 'cpu-chip'],
        ];

        $sectors = [];
        foreach ($sectorData as $data) {
            $sectors[$data['slug']] = Sector::create($data);
        }

        // Assign sectors to MP for personalized feed
        $mp->sectors()->attach([
            $sectors['health']->id,
            $sectors['macroeconomics']->id,
            $sectors['infrastructure']->id,
            $sectors['energy']->id,
        ]);

        // ═══════════════════════════════════════════════════════════════
        // POLICY BRIEFS (10 published, covering various sectors/urgencies)
        // ═══════════════════════════════════════════════════════════════
        $briefsData = [
            [
                'title' => 'Climate Resilience of National Grid Infrastructure: Risk Assessment',
                'slug' => 'climate-resilience-grid-infrastructure',
                'summary' => 'A comprehensive assessment of vulnerabilities in the national power grid due to extreme weather events, with recommendations for adaptive infrastructure investment.',
                'urgency' => 'high',
                'sector' => 'energy',
            ],
            [
                'title' => 'Economic Impact of Proposed Mining Reforms in Resource-Rich Provinces',
                'slug' => 'economic-impact-mining-reforms',
                'summary' => 'Analysis of the projected fiscal and employment effects of the Mineral Resources Bill, including regional distributional impacts on mining-dependent communities.',
                'urgency' => 'high',
                'sector' => 'macroeconomics',
            ],
            [
                'title' => 'Universal Healthcare Coverage: Financing Models and Implementation Roadmap',
                'slug' => 'universal-healthcare-coverage-financing',
                'summary' => 'Evaluation of three financing models for achieving universal health coverage, with cost projections, fiscal space analysis, and phased implementation timelines.',
                'urgency' => 'medium',
                'sector' => 'health',
            ],
            [
                'title' => 'Digital Infrastructure Gap Analysis for Rural Constituencies',
                'slug' => 'digital-infrastructure-rural-gap-analysis',
                'summary' => 'Mapping broadband connectivity across all constituencies, identifying underserved areas, and estimating investment requirements for universal digital access.',
                'urgency' => 'medium',
                'sector' => 'infrastructure',
            ],
            [
                'title' => 'Agricultural Export Competitiveness Under New Trade Agreements',
                'slug' => 'agricultural-export-competitiveness',
                'summary' => 'Assessment of how the African Continental Free Trade Area agreement will affect agricultural exports, identifying priority value chains for investment.',
                'urgency' => 'medium',
                'sector' => 'agriculture',
            ],
            [
                'title' => 'Energy Transition Pathways: Just Transition Framework for Coal-Dependent Regions',
                'slug' => 'energy-transition-just-transition-framework',
                'summary' => 'Policy framework for managing the transition from coal to renewable energy, with social protection mechanisms for affected workers and communities.',
                'urgency' => 'high',
                'sector' => 'energy',
            ],
            [
                'title' => 'Early Childhood Development: Returns on Investment Analysis',
                'slug' => 'early-childhood-development-roi',
                'summary' => 'Long-term economic and social returns of expanding early childhood development programmes, with cost-benefit analysis across various intervention models.',
                'urgency' => 'low',
                'sector' => 'education',
            ],
            [
                'title' => 'Water Security Infrastructure: Inter-Basin Transfer Feasibility',
                'slug' => 'water-security-inter-basin-transfer',
                'summary' => 'Technical and economic feasibility study of proposed inter-basin water transfer schemes to address growing water scarcity in industrial corridors.',
                'urgency' => 'medium',
                'sector' => 'infrastructure',
            ],
            [
                'title' => 'Cybersecurity Preparedness of National Critical Infrastructure',
                'slug' => 'cybersecurity-preparedness-critical-infrastructure',
                'summary' => 'Audit of cybersecurity vulnerabilities across government digital systems, energy grids, and financial infrastructure with remediation prioritisation.',
                'urgency' => 'high',
                'sector' => 'defence',
            ],
            [
                'title' => 'Green Hydrogen Strategy: Market Opportunities and Investment Framework',
                'slug' => 'green-hydrogen-market-opportunities',
                'summary' => 'Strategic assessment of the global green hydrogen market, national competitive advantages, and the investment framework required to attract capital.',
                'urgency' => 'low',
                'sector' => 'environment',
            ],
        ];

        foreach ($briefsData as $i => $data) {
            PolicyBrief::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'summary' => $data['summary'],
                'full_content' => "## Executive Summary\n\n{$data['summary']}\n\n## Background\n\nThis policy brief provides a detailed analysis of the subject matter, drawing on the latest available data and research. The analysis considers multiple stakeholder perspectives and provides evidence-based recommendations.\n\n## Key Findings\n\n1. **Primary Finding:** The evidence indicates significant implications for policy development and resource allocation.\n2. **Secondary Finding:** Regional variations require differentiated implementation strategies.\n3. **Tertiary Finding:** International best practices offer valuable lessons for domestic policy design.\n\n## Policy Recommendations\n\n### Short-term (0–12 months)\n- Establish a cross-departmental task force to coordinate implementation\n- Commission detailed feasibility studies for priority interventions\n\n### Medium-term (1–3 years)\n- Allocate dedicated funding streams in the next budget cycle\n- Develop regulatory frameworks to support implementation\n\n### Long-term (3–5 years)\n- Monitor and evaluate impact with annual reporting to Parliament\n- Adjust strategies based on emerging evidence and changing circumstances\n\n## Conclusion\n\nThe analysis demonstrates that timely policy action is warranted. The recommended interventions are projected to deliver significant benefits relative to costs, with particularly strong returns for vulnerable communities.",
                'sector_id' => $sectors[$data['sector']]->id,
                'urgency_level_enum' => $data['urgency'],
                'status_enum' => BriefStatus::Published,
                'published_at' => now()->subDays(rand(1, 60)),
                'compiled_by' => $seniorResearcher->id,
                'verified_by' => $admin->id,
                'views_count' => rand(50, 500),
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        // BILLS (15 across all statuses with voting records)
        // ═══════════════════════════════════════════════════════════════
        $billsData = [
            ['title' => 'Electricity Regulation Amendment Bill', 'id' => 'B-2024-001', 'house' => 'National Assembly', 'status' => BillStatus::CommitteeStage, 'sector' => 'energy'],
            ['title' => 'National Health Insurance Bill', 'id' => 'B-2024-002', 'house' => 'National Assembly', 'status' => BillStatus::SecondReading, 'sector' => 'health'],
            ['title' => 'Climate Change Adaptation Fund Bill', 'id' => 'B-2024-003', 'house' => 'National Assembly', 'status' => BillStatus::FirstReading, 'sector' => 'environment'],
            ['title' => 'Digital Identity and Data Protection Bill', 'id' => 'B-2024-004', 'house' => 'National Assembly', 'status' => BillStatus::Tabled, 'sector' => 'digital-economy'],
            ['title' => 'Mining and Mineral Resources Amendment Bill', 'id' => 'B-2024-005', 'house' => 'National Assembly', 'status' => BillStatus::Passed, 'sector' => 'macroeconomics'],
            ['title' => 'Agricultural Land Reform Bill', 'id' => 'B-2024-006', 'house' => 'Senate', 'status' => BillStatus::CommitteeStage, 'sector' => 'agriculture'],
            ['title' => 'Basic Education Infrastructure Bill', 'id' => 'B-2024-007', 'house' => 'National Assembly', 'status' => BillStatus::SecondReading, 'sector' => 'education'],
            ['title' => 'National Cybersecurity Framework Bill', 'id' => 'B-2024-008', 'house' => 'Senate', 'status' => BillStatus::FirstReading, 'sector' => 'defence'],
            ['title' => 'Public Procurement Reform Bill', 'id' => 'B-2024-009', 'house' => 'National Assembly', 'status' => BillStatus::Tabled, 'sector' => 'macroeconomics'],
            ['title' => 'Water Services Infrastructure Bill', 'id' => 'B-2024-010', 'house' => 'National Assembly', 'status' => BillStatus::CommitteeStage, 'sector' => 'infrastructure'],
            ['title' => 'Small Business Development Bill', 'id' => 'B-2024-011', 'house' => 'National Assembly', 'status' => BillStatus::Passed, 'sector' => 'trade'],
            ['title' => 'Renewable Energy Feed-in Tariff Bill', 'id' => 'B-2024-012', 'house' => 'Senate', 'status' => BillStatus::Vetoed, 'sector' => 'energy'],
            ['title' => 'Cross-Border Trade Facilitation Bill', 'id' => 'B-2024-013', 'house' => 'National Assembly', 'status' => BillStatus::SecondReading, 'sector' => 'trade'],
            ['title' => 'Mental Health Services Bill', 'id' => 'B-2024-014', 'house' => 'Senate', 'status' => BillStatus::FirstReading, 'sector' => 'health'],
            ['title' => 'Transport Corridor Development Bill', 'id' => 'B-2024-015', 'house' => 'National Assembly', 'status' => BillStatus::CommitteeStage, 'sector' => 'infrastructure'],
        ];

        foreach ($billsData as $data) {
            $bill = Bill::create([
                'title' => $data['title'],
                'local_identifier' => $data['id'],
                'house_origin' => $data['house'],
                'status_enum' => $data['status'],
                'current_stage_description' => match ($data['status']) {
                    BillStatus::Tabled => 'Bill tabled for introduction. Awaiting first reading.',
                    BillStatus::FirstReading => 'First reading completed. Bill published for public comment.',
                    BillStatus::SecondReading => 'Second reading debate in progress. Committee referral pending.',
                    BillStatus::CommitteeStage => 'Under committee review. Public hearings being conducted.',
                    BillStatus::Passed => 'Bill passed by both houses. Awaiting presidential assent.',
                    BillStatus::Vetoed => 'Bill vetoed by the President. Returned to Parliament with recommendations.',
                },
                'constitutional_implications_summary' => 'This bill engages several constitutional provisions including the Bill of Rights, division of powers between national and provincial spheres, and the principles of co-operative governance. Legal review indicates the bill is consistent with constitutional requirements subject to the amendments noted.',
                'comparison_matrix' => [
                    'sections' => [
                        ['section' => 'Preamble', 'original' => 'Recognising the need to address systemic challenges in the sector...', 'amended' => 'Recognising the urgent need to address systemic challenges and inequities in the sector...', 'type' => 'modified'],
                        ['section' => 'Section 4(1)', 'original' => 'The Minister may prescribe regulations within 12 months.', 'amended' => '', 'type' => 'removed'],
                        ['section' => 'Section 4(2)', 'original' => '', 'amended' => 'The Minister shall, after consultation with relevant stakeholders, prescribe regulations within 18 months.', 'type' => 'added'],
                    ],
                ],
                'sector_id' => $sectors[$data['sector']]->id,
                'tabled_at' => now()->subDays(rand(10, 180)),
                'voting_records' => [
                    'yea' => rand(150, 280),
                    'nay' => rand(20, 100),
                    'abstain' => rand(5, 30),
                    'caucus' => [
                        'ANC' => ['yea' => rand(120, 180), 'nay' => rand(0, 10), 'abstain' => rand(0, 5)],
                        'DA' => ['yea' => rand(10, 40), 'nay' => rand(20, 50), 'abstain' => rand(2, 10)],
                        'EFF' => ['yea' => rand(5, 20), 'nay' => rand(15, 35), 'abstain' => rand(3, 8)],
                        'IFP' => ['yea' => rand(5, 15), 'nay' => rand(3, 10), 'abstain' => rand(1, 5)],
                    ],
                ],
            ]);

            // Add an amendment for bills beyond Tabled stage
            if ($data['status'] !== BillStatus::Tabled) {
                BillAmendment::create([
                    'bill_id' => $bill->id,
                    'version' => 1,
                    'original_text' => 'Original text of the bill as introduced. It contained provisions for...',
                    'amended_text' => 'Amended text incorporating changes from the portfolio committee...',
                    'diff_summary' => ['type' => 'modified', 'sections_affected' => 3],
                    'amendment_notes' => 'Portfolio committee amendments adopted on ' . now()->subDays(rand(5, 30))->format('j F Y') . '.',
                    'proposed_by' => $seniorResearcher->id,
                    'applied_at' => now()->subDays(rand(3, 20)),
                ]);
            }
        }

        // ═══════════════════════════════════════════════════════════════
        // EXPERT QUERIES (5 across various states)
        // ═══════════════════════════════════════════════════════════════
        $queriesData = [
            [
                'title' => 'Comparative analysis of grid battery storage costs',
                'description' => 'Need cost comparison data for utility-scale battery storage systems vs. pumped hydro for the Energy Committee briefing next week.',
                'tier' => TurnaroundTier::FortyEightHour,
                'status' => QueryStatus::Completed,
                'response' => 'Our analysis indicates lithium-ion battery storage costs have declined to $150-200/kWh for utility-scale installations, while pumped hydro remains at $100-150/kWh but with significant geographic constraints. Detailed comparison matrix attached.',
                'assigned' => $juniorResearcher->id,
                'resolved' => true,
            ],
            [
                'title' => 'Impact of interest rate changes on mortgage defaults',
                'description' => 'Need data on how the recent 50bps rate hike affects mortgage default rates across income quintiles. Constituency concerns in Johannesburg Central.',
                'tier' => TurnaroundTier::Standard,
                'status' => QueryStatus::InProgress,
                'assigned' => $juniorResearcher->id,
                'resolved' => false,
            ],
            [
                'title' => 'Emergency floor support: Mining Bill amendment implications',
                'description' => 'URGENT: Need immediate analysis of how proposed amendments to Section 24 of the Mining Bill affect artisanal miners in my constituency. Currently on the floor.',
                'tier' => TurnaroundTier::ThirtyMinFloor,
                'status' => QueryStatus::Pending,
                'assigned' => null,
                'resolved' => false,
            ],
            [
                'title' => 'School infrastructure backlog data by province',
                'description' => 'Need updated statistics on the school infrastructure backlog, specifically the number of schools still using pit latrines and without electricity, broken down by province.',
                'tier' => TurnaroundTier::Standard,
                'status' => QueryStatus::Assigned,
                'assigned' => $juniorResearcher->id,
                'resolved' => false,
            ],
            [
                'title' => 'Review: Healthcare financing policy brief draft',
                'description' => 'Senior review requested for the response prepared on NHI financing models. Needs editorial review before transmission.',
                'tier' => TurnaroundTier::FortyEightHour,
                'status' => QueryStatus::SeniorReview,
                'response' => 'The NHI financing analysis is comprehensive. However, the fiscal space projections need updating with the latest Treasury numbers. I have revised Section 3 with corrected data.',
                'assigned' => $juniorResearcher->id,
                'resolved' => false,
            ],
        ];

        $billsForQueries = Bill::whereIn('status_enum', [BillStatus::CommitteeStage, BillStatus::SecondReading])->get();

        foreach ($queriesData as $i => $data) {
            $query = ExpertQuery::create([
                'user_id' => $mp->id,
                'title' => $data['title'],
                'explicit_description' => $data['description'],
                'status_enum' => $data['status'],
                'turnaround_tier_enum' => $data['tier'],
                'assigned_researcher_id' => $data['assigned'],
                'bill_id' => $data['tier'] === TurnaroundTier::ThirtyMinFloor && $billsForQueries->isNotEmpty()
                    ? $billsForQueries->random()->id : null,
                'target_deadline' => match ($data['tier']) {
                    TurnaroundTier::ThirtyMinFloor => now()->addHour(),
                    TurnaroundTier::FortyEightHour => now()->addHours(48),
                    TurnaroundTier::Standard => now()->addDays(7),
                },
                'response_text' => $data['response'] ?? null,
                'resolved_at' => $data['resolved'] ? now()->subHours(rand(2, 24)) : null,
            ]);

            // Mark one query as SLA-breached (the pending floor support one that's been sitting too long)
            if ($i === 2) {
                $query->update([
                    'sla_breached_at' => now()->subMinutes(45),
                    'sla_breach_notified' => true,
                    'target_deadline' => now()->subMinutes(30),
                ]);
            }

            // If in senior review, set the senior reviewer
            if ($data['status'] === QueryStatus::SeniorReview) {
                $query->update([
                    'reviewed_by' => $seniorResearcher->id,
                    'senior_notes' => 'Please update the fiscal projections with Q3 data from Treasury before final approval.',
                ]);
            }
        }

        // ═══════════════════════════════════════════════════════════════
        // ADDITIONAL MP: Link constituency and sectors for full demo
        // ═══════════════════════════════════════════════════════════════
        $committeeChair->sectors()->attach([
            $sectors['defence']->id,
            $sectors['trade']->id,
            $sectors['infrastructure']->id,
        ]);
    }
}
