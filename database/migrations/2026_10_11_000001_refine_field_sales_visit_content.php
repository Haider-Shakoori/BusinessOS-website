<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('seo_pages')->where('slug', 'field-sales-visit-management-software')->first();

        // Only touch the shipped default. Editors may have changed the CMS copy.
        if (! $page || trim((string) $page->content) !== trim($this->legacyContent())) {
            return;
        }

        $changes = [
            'content' => $this->refinedContent(),
            'updated_at' => now(),
        ];

        if ($page->headline === 'Field sales software that connects territories, customer visits, orders, collections and follow-up.') {
            $changes['headline'] = 'Plan customer visits, capture outcomes and keep missed follow-ups visible.';
        }

        if ($page->excerpt === 'Give supervisors a clear view of assigned customers, planned visits, field activity and commercial outcomes without reducing performance to GPS points.') {
            $changes['excerpt'] = 'Turn customer assignments into a clear daily mobile workflow with visit outcomes, missed-visit reasons and accountable follow-up.';
        }

        DB::table('seo_pages')
            ->where('id', $page->id)
            ->where('content', $page->content)
            ->update($changes);
    }

    public function down(): void
    {
        $page = DB::table('seo_pages')->where('slug', 'field-sales-visit-management-software')->first();

        // Only touch the shipped default. Editors may have changed the CMS copy.
        if (! $page || trim((string) $page->content) !== trim($this->refinedContent())) {
            return;
        }

        $changes = [
            'content' => $this->legacyContent(),
            'updated_at' => now(),
        ];

        if ($page->headline === 'Plan customer visits, capture outcomes and keep missed follow-ups visible.') {
            $changes['headline'] = 'Field sales software that connects territories, customer visits, orders, collections and follow-up.';
        }

        if ($page->excerpt === 'Turn customer assignments into a clear daily mobile workflow with visit outcomes, missed-visit reasons and accountable follow-up.') {
            $changes['excerpt'] = 'Give supervisors a clear view of assigned customers, planned visits, field activity and commercial outcomes without reducing performance to GPS points.';
        }

        DB::table('seo_pages')
            ->where('id', $page->id)
            ->where('content', $page->content)
            ->update($changes);
    }

    private function legacyContent(): string
    {
        return <<<'TEXT'
Field-sales management is easier when location is connected to the customer workflow rather than collected as an isolated trail of coordinates.

## Start with customer and territory responsibility

Every field employee should know which customers and territory they are responsible for. Managers should be able to assign customers directly or organize them through territories and routes.

A map can make territory creation and customer placement easier for non-technical users.

## Plan visits around business purpose

A visit record should identify the customer, assigned salesman, planned date or route and the expected purpose where relevant. The mobile app can then present today's work without requiring the salesman to search through every customer.

## Record the visit outcome

Check-in alone is not enough. The visit should connect to outcomes such as an order, collection, note, follow-up date, issue or completed task.

That context lets supervisors distinguish activity from productive progress.

## Use location as validation

Customer coordinates and geofences can help confirm whether check-in happened near the customer location. Territory maps can help management review coverage.

Location should support workflow validation rather than become the only measure of employee performance.

## Keep working through weak connectivity

Field teams frequently work where mobile data is inconsistent. Offline-first mobile design can preserve assigned customers and permitted actions locally, queue transactions and synchronize them when the connection returns.

## Build the customer history

Orders, collections, visits, notes, referrals and follow-ups become more valuable when they remain available from the same customer profile.

FieldPulse by BusinessOS is designed around this connected field workflow for sales teams, supervisors and administrators.
TEXT;
    }

    private function refinedContent(): string
    {
        return <<<'TEXT'
Visit management answers a specific operational question: which customer should a salesperson visit, what happened during that visit, and what still needs follow-up? It is one workflow within a wider field-sales system—not a substitute for attendance, territory administration, payroll or company-wide sales reporting.

## Before the visit: prepare the daily plan

A supervisor assigns each customer to a responsible salesperson and may set a date, route, priority or purpose. The mobile list should distinguish due visits from future appointments so a salesperson does not have to search the full customer directory.

Record the latest customer address and an agreed contact person where available. If a visit cannot be completed, preserve the assigned customer and its history instead of deleting the task.

## At the customer: capture an outcome, not only a GPS point

A useful visit record links the customer, employee, time, visit type and an outcome. Outcomes might include an order placed, a collection recorded, a follow-up requested, a complaint or a reason for an unsuccessful visit.

Coordinates or a geofence can provide supporting evidence of where a check-in occurred. They do not, by themselves, demonstrate a successful sale or collection. When a visit is outside an expected area, the system should flag the exception for review rather than silently discarding the record.

## After the visit: close the follow-up loop

A completed visit may create a next action with an owner and due date. A missed appointment should retain its reason and proposed reschedule date. Supervisors need to see overdue follow-ups and unvisited assigned customers alongside completed visits.

Separate the visit status from commercial outcomes: a visit can be completed without an order, and an order should not automatically mark every scheduled visit as completed.

## Example: a distributor's morning route

In a hypothetical daily route, a supervisor assigns ten customer visits. Seven are completed, two customers are unavailable and one stop is deferred. The useful report identifies the three unfinished stops and their next actions; it does not present ten assigned visits as ten successful visits. An order or payment collected at any stop should be linked to the relevant customer transaction, not counted merely because the salesperson checked in.

## When internet connectivity is unreliable

The mobile app should indicate whether a visit is saved locally or synchronized to the server. Give offline records stable identifiers so a retry does not create duplicate visits, orders or collections. The server should preserve the relevant timestamps and surface conflicts for review instead of quietly overwriting changes.

## Review performance fairly

Managers can compare assigned versus completed visits, overdue follow-ups, customer coverage and recorded sales outcomes. Interpret these measures together: a long customer meeting may produce more value than many short check-ins.

For team-wide attendance, shift management, territory administration and reporting beyond individual visits, use the broader Field Sales Management Software service.
TEXT;
    }

};
