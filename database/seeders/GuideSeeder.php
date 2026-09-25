<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            [
                'title' => 'How to Improve Field Sales Visibility Without Micromanaging',
                'slug' => 'improve-field-sales-visibility-without-micromanaging',
                'category' => 'Field Sales',
                'excerpt' => 'A practical framework for understanding field activity while keeping managers focused on outcomes rather than constant surveillance.',
                'content' => <<<'TEXT'
Field sales visibility is useful when it helps managers understand execution, remove blockers and support the team. It becomes counterproductive when visibility turns into constant monitoring without a clear operational purpose.

Start with the questions the business actually needs answered. Are representatives starting work when expected? Are planned customers being visited? Are territories receiving enough coverage? Are there gaps between scheduled activity and completed activity? These questions are more useful than simply asking where a person is every minute of the day.

A strong field-sales workflow connects attendance, customer visits, route context and outcomes. Attendance alone tells you that a workday started. GPS alone tells you that a device moved. A customer visit record adds business context. Together, these signals help managers understand what happened without relying entirely on end-of-day messages and spreadsheets.

The next principle is proportionality. Collect only the location and activity data that supports a defined business workflow. Make working hours, tracking behavior and expectations clear to field staff. Visibility should improve coordination and accountability, not create uncertainty about how data is being used.

Managers also need exception-based views. Instead of reading every movement, the system should surface what needs attention: missed visits, unusual gaps, incomplete routes, delayed synchronization or repeated territory coverage problems. This reduces noise and makes operational reviews more useful.

Finally, design for imperfect connectivity. Field teams often work in areas where mobile data is slow or temporarily unavailable. A field-sales system should preserve essential workflows offline and synchronize safely when the connection returns.

Good visibility is not about collecting the most data. It is about connecting the smallest useful set of signals to clear operational questions, then presenting those answers in a way managers and field teams can act on.
TEXT,
                'meta_title' => 'Improve Field Sales Visibility Without Micromanaging | BusinessOS',
                'meta_description' => 'Learn how to improve field sales visibility using attendance, client visits, routes and exception-based management without creating unnecessary surveillance.',
            ],
            [
                'title' => 'What to Look for in Field Sales Tracking Software',
                'slug' => 'what-to-look-for-in-field-sales-tracking-software',
                'category' => 'Software Guide',
                'excerpt' => 'A buyer-oriented checklist for evaluating field sales software around workflows, offline operation, management visibility and practical adoption.',
                'content' => <<<'TEXT'
Field sales tracking software should make daily field work easier to coordinate. The strongest evaluation starts with your workflow rather than a long feature checklist.

Map a normal field day first. How does a representative start work? How are customers assigned or planned? What information is recorded during a visit? What happens when the phone has no internet connection? How does a manager review progress? Software that cannot support this sequence clearly will create workarounds even if it has many features.

Offline behavior deserves special attention. A mobile application may look fast in an office but behave very differently on an unstable connection. Ask what happens when a user checks in, records a visit or captures activity without connectivity. The system should explain what is stored locally, what the user can continue doing and how synchronization is handled later.

Management visibility should also be connected to business context. A map can be useful, but a map alone does not explain whether the correct customers were visited or whether a territory is being covered effectively. Look for reporting that connects location, attendance, customers, visits and performance questions.

Usability matters because field software is used repeatedly throughout the day. Common actions should require few steps, mobile controls should be easy to operate, and the interface should make synchronization or offline state understandable.

Security and permissions should match the organization. Managers, administrators and field staff usually need different levels of access. If multiple companies or business units use the system, data boundaries need to be explicit.

Finally, evaluate how the product is implemented and supported. Ask about onboarding, deployment, backups, data export, integration requirements and how product changes are communicated.

The right field sales platform is not necessarily the one with the longest feature list. It is the one that fits the daily operating model, stays reliable under real field conditions and gives managers useful information without making the team fight the software.
TEXT,
                'meta_title' => 'What to Look for in Field Sales Tracking Software | BusinessOS',
                'meta_description' => 'Evaluate field sales tracking software with a practical checklist covering workflows, offline use, maps, reporting, permissions and adoption.',
            ],
            [
                'title' => 'Why Offline-First Design Matters for Field Operations',
                'slug' => 'why-offline-first-design-matters-for-field-operations',
                'category' => 'Mobile Operations',
                'excerpt' => 'Understand what offline-first actually means and why it changes reliability for field teams working with slow or intermittent mobile internet.',
                'content' => <<<'TEXT'
Offline-first design starts from a simple assumption: connectivity will sometimes fail, and the user should still be able to complete essential work.

This is different from adding an offline screen after a web-connected workflow has already been designed. In an offline-first product, the mobile application treats local state as part of the normal operating model. Important actions can be recorded on the device, clearly marked for synchronization and sent to the server when a reliable connection returns.

For field teams, this affects both usability and data quality. If a representative cannot record a customer visit because the signal disappeared, the usual alternatives are memory, paper notes or a message sent later. Each alternative creates a gap between when the activity happened and when the system learned about it.

A good offline workflow also needs conflict rules. The product should know how to handle records that changed on both the device and server, repeated submissions, delayed timestamps and retries. Synchronization is not just a button; it is a data-consistency problem.

The interface should make state visible. Users need to understand whether an action is saved locally, synchronized successfully or waiting for a connection. Silent failure is particularly damaging because the user may assume the server received information that never left the device.

Offline-first does not mean every feature must work without internet. Some functions, such as retrieving large live datasets or running cloud-based analysis, may reasonably require connectivity. The important decision is identifying which field actions are essential and ensuring those actions degrade gracefully.

For organizations operating across areas with inconsistent mobile coverage, offline-first design is not an optimization for rare edge cases. It is part of making the product dependable under the conditions where the work actually happens.
TEXT,
                'meta_title' => 'Why Offline-First Design Matters for Field Operations | BusinessOS',
                'meta_description' => 'Learn how offline-first mobile design improves reliability, synchronization and data quality for field sales and operations teams.',
            ],
        ];

        foreach ($guides as $guide) {
            Guide::updateOrCreate(
                ['slug' => $guide['slug']],
                [
                    ...$guide,
                    'author_name' => 'BusinessOS Editorial Team',
                    'author_role' => 'Business software & operations',
                    'author_bio' => 'BusinessOS publishes practical guidance based on software engineering, operational workflows and implementation experience.',
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }
}
