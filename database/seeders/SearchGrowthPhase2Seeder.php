<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SearchGrowthPhase2Seeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->servicePages() as $page) {
            SeoPage::updateOrCreate(
                ['slug' => $page['slug']],
                [...$page, 'status' => 'published', 'published_at' => now()]
            );
        }

        foreach ($this->guides() as $guide) {
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

    private function servicePages(): array
    {
        return [
            [
                'title' => 'Offline Business Software',
                'slug' => 'offline-business-software',
                'eyebrow' => 'Reliable software for weak connectivity',
                'headline' => 'Business software designed to keep important work moving when internet connectivity is unreliable.',
                'excerpt' => 'Plan offline-first workflows for field sales, retail, pharmacy and operational teams that cannot stop working every time the network becomes slow or unavailable.',
                'content' => <<<'TEXT'
Offline business software is not the same as simply saving a web page for later. A reliable offline-first workflow decides which actions can continue without a connection, what data must be available locally, how conflicts are resolved and what users should see while synchronization is pending.

## Start with the business actions that cannot stop

The first design question is operational. A field salesman may need to open assigned customers, record a visit, create an order or confirm a collection while mobile data is unavailable. A retail cashier may need to continue checkout even when the internet connection to the central server is unstable. A pharmacy may need local access to products, selling prices and available stock.

Not every function needs to work offline. Administrative reporting, large exports and configuration can remain online if that reduces complexity. The offline scope should concentrate on transactions that would otherwise stop the business.

## Keep the local data set intentional

Offline applications should not copy the entire server database to every device. The local store should contain the records required by that user or branch, such as assigned customers, products, prices, open visits or a permitted stock snapshot.

This reduces synchronization time and limits unnecessary data exposure.

## Queue transactions instead of hiding failures

When a user saves an offline transaction, the application should clearly mark it as waiting to synchronize. The action needs a local identifier so repeated retries do not create duplicate orders, collections or visits.

Once connectivity returns, the synchronization process should send pending transactions safely and confirm which records were accepted by the server.

## Design for conflict resolution

Conflicts happen when the same record changes on more than one device or on the server. The correct rule depends on the data. A customer note may allow a simple merge, while a financial collection or stock transaction may require server-side validation and a clear rejection message.

Users should never be left guessing whether an action was synchronized.

## Keep security in the offline model

Offline capability does not mean unrestricted local access. Authentication state, encrypted local storage, device permissions, session expiry and remote revocation all need consideration.

BusinessOS can design offline-capable web and mobile workflows for environments where connectivity is inconsistent. The goal is not to make every screen offline. It is to protect the business activities that matter most when the network is unreliable.
TEXT,
                'target_keywords' => ['offline business software', 'offline first software', 'software for poor internet', 'offline sales app', 'offline POS software'],
                'related_product_slugs' => ['fieldpulse', 'pos', 'pharmacy-management', 'erp'],
                'faq' => [
                    ['question' => 'What does offline-first business software mean?', 'answer' => 'Offline-first software allows selected business actions to continue locally when the network is unavailable and synchronizes approved data when connectivity returns.'],
                    ['question' => 'Does every feature need to work offline?', 'answer' => 'No. The best design keeps critical operational actions available offline while leaving heavy reporting and administration online when that is safer and simpler.'],
                    ['question' => 'How are duplicate transactions prevented during synchronization?', 'answer' => 'Offline transactions should use stable local identifiers and idempotent server rules so retries do not create duplicate orders, payments or visits.'],
                ],
                'meta_title' => 'Offline Business Software for Weak Internet | BusinessOS',
                'meta_description' => 'Offline-first business software for field sales, POS, pharmacy and operational workflows that need to keep working through weak or unstable internet.',
            ],
            [
                'title' => 'Supermarket POS Software',
                'slug' => 'supermarket-pos-software',
                'eyebrow' => 'Retail checkout and stock control',
                'headline' => 'Supermarket POS software built for fast checkout, inventory visibility and controlled daily closing.',
                'excerpt' => 'Run cashier sales, product lookup, discounts, receipts, stock movement and end-of-day control from one retail workflow.',
                'content' => <<<'TEXT'
A supermarket POS system has to be fast enough for continuous checkout and controlled enough for management to explain sales, cash and stock after the shift ends.

## Make checkout the fastest workflow

Cashiers repeatedly perform the same actions: find a product, change quantity, apply an allowed discount, take payment and complete the sale. The POS interface should minimize navigation and avoid exposing back-office complexity during checkout.

Keyboard shortcuts, barcode support where the business wants it, product search and responsive controls can all reduce queue time.

## Connect every completed sale to stock

A sale should create a traceable inventory effect. Management should be able to move from the current stock balance back to the sales, purchases, adjustments or transfers that changed it.

Voids and returns also need controlled stock effects. Deleting the original sale is weaker than recording a reversal because it removes the history.

## Separate cashier responsibility

Each cashier or shift should have a clear opening and closing state. The closing process can compare expected cash with confirmed cash and preserve any difference for review.

This is more useful than simply displaying the day's sales total because it connects financial responsibility to the person and period that handled the money.

## Keep prices and discounts controlled

Retail pricing may include normal selling price, promotions and approved manual discounts. Permissions should define who can change price or discount at checkout.

Repeated manual overrides should be reportable so management can review unusual patterns.

## Plan for unreliable connectivity

Where internet service is inconsistent, the checkout design should avoid unnecessary remote dependencies. Depending on the architecture, a branch can keep critical selling data locally and synchronize safely with the central system.

## Connect POS to the back office when needed

A growing supermarket may eventually need supplier purchasing, warehouse transfers, expenses, accounting or multi-branch reporting. POS should remain simple at the counter while broader ERP or back-office functions handle the operational complexity behind it.

BusinessOS POS is designed around cashier speed, stock visibility, closing control and multilingual retail operation.
TEXT,
                'target_keywords' => ['supermarket POS software', 'retail POS system', 'grocery store POS', 'POS inventory software', 'cashier closing software'],
                'related_product_slugs' => ['pos', 'erp'],
                'faq' => [
                    ['question' => 'What should supermarket POS software include?', 'answer' => 'Core features usually include fast checkout, product search, payments, receipts, stock updates, cashier shifts, closing and controlled returns or voids.'],
                    ['question' => 'Can POS software connect to inventory?', 'answer' => 'Yes. Completed sales can create controlled stock movements so the inventory balance remains tied to the transactions that changed it.'],
                    ['question' => 'Can a supermarket POS work with weak internet?', 'answer' => 'It can be designed to keep critical branch or checkout operations available locally and synchronize with central services when connectivity returns.'],
                ],
                'meta_title' => 'Supermarket POS Software & Inventory | BusinessOS',
                'meta_description' => 'Supermarket POS software for fast checkout, cashier shifts, receipts, inventory movement, discounts, returns and controlled daily closing.',
            ],
            [
                'title' => 'Pharmacy Inventory & Expiry Software',
                'slug' => 'pharmacy-inventory-expiry-software',
                'eyebrow' => 'Pharmacy stock control',
                'headline' => 'Pharmacy inventory software that keeps stock, batches, expiry dates and purchasing connected.',
                'excerpt' => 'Track medicine receiving, batch expiry, near-expiry stock, sales and replenishment without separating expiry control from everyday inventory.',
                'content' => <<<'TEXT'
Pharmacy inventory has an extra dimension that ordinary stock systems often miss: the same medicine can exist in several batches with different expiry dates.

## Capture batch and expiry information when stock arrives

Expiry control is strongest when the receiving workflow captures the medicine, quantity, batch or lot where required, expiry date and supplier reference at the moment the stock enters the pharmacy.

Adding expiry information later creates a gap between the physical medicine and the system record.

## Keep multiple batches separate

If two batches of the same medicine have different expiry dates, combining them into one stock row makes expiry reporting unreliable. The system should preserve batch identity while still allowing users to see the total available quantity for the medicine.

## Make near-expiry reports actionable

A useful report should answer which products are already expired, which will expire within a chosen period, how much quantity is affected and where that stock is located.

The pharmacy can then decide whether to transfer, prioritize, return or stop reordering an item.

## Connect sales with expiry-aware stock

The system can guide staff toward earlier-expiring batches where the pharmacy's policy requires it. Software can provide the recommendation and preserve the transaction, while the physical selection still depends on staff discipline.

## Improve purchasing decisions

Reordering should consider usable stock, movement history and near-expiry exposure. Ordering more stock simply because the total quantity is low can still create waste if the remaining inventory is moving slowly.

## Design for branch and offline realities

A pharmacy may need local selling capability when the internet is weak. The architecture should define how prices, products and permitted stock data remain available locally and how sales synchronize later.

BusinessOS pharmacy workflows can combine purchasing, inventory, expiry control and offline-capable selling around one consistent product record.
TEXT,
                'target_keywords' => ['pharmacy inventory software', 'pharmacy expiry software', 'medicine batch tracking', 'pharmacy stock management', 'pharmacy purchasing software'],
                'related_product_slugs' => ['pharmacy-management', 'erp'],
                'faq' => [
                    ['question' => 'Why should pharmacy software track batches separately?', 'answer' => 'Different batches of the same medicine can have different expiry dates, so batch identity is needed for accurate expiry reporting and stock decisions.'],
                    ['question' => 'What is a near-expiry report?', 'answer' => 'It lists stock that will expire within a chosen period so the pharmacy can prioritize, transfer, return or avoid unnecessary replenishment.'],
                    ['question' => 'Can pharmacy sales work offline?', 'answer' => 'Selected selling workflows can be designed to continue locally and synchronize later, provided the system has clear rules for prices, stock and conflict handling.'],
                ],
                'meta_title' => 'Pharmacy Inventory & Expiry Software | BusinessOS',
                'meta_description' => 'Pharmacy inventory software for medicine batches, expiry dates, near-expiry reporting, purchasing, stock control and offline-capable sales.',
            ],
            [
                'title' => 'Manufacturing Inventory & BOM Software',
                'slug' => 'manufacturing-inventory-bom-software',
                'eyebrow' => 'Production material control',
                'headline' => 'Manufacturing software that connects BOM planning, actual material consumption, inventory and production cost.',
                'excerpt' => 'Keep planned recipes and actual factory usage side by side so production quantity, material variance and realized cost can be explained.',
                'content' => <<<'TEXT'
Manufacturing inventory becomes difficult when planning quantities, actual consumption and stock deductions are stored in separate files.

## Use the BOM as a planning baseline

A bill of materials should describe the expected materials and quantities required for a product or production quantity. That baseline can support material planning, quotation, standard cost and production preparation.

The BOM should not be silently replaced with actual usage after production because the original plan is needed for variance analysis.

## Record actual consumption separately

Production staff may consume more or less material than the standard quantity because of waste, machine settings, moisture, setup loss or operational decisions.

The system should record the approved actual quantity for each material and preserve the difference from the plan.

## Connect approved consumption to inventory

When production is completed, the inventory deduction should reference the production event and the approved actual material usage. This creates a traceable path from stock movement to production record.

Finished-goods receipt should follow the same principle so output quantity is also explained by a production transaction.

## Calculate realized production cost

Realized cost can combine actual material consumption with the applicable inventory cost basis and approved labor, overhead or process costs.

Management can then compare quoted, standard and realized cost instead of relying on one number for every purpose.

## Investigate repeated variance

Variance becomes more useful when it can be reviewed by product, material, machine, shift, operator or period. A repeated variance may indicate that the standard BOM needs revision or that the production process is unstable.

BusinessOS manufacturing workflows are designed to preserve the relationship between BOM, production plan, actual consumption, stock and costing rather than treating them as isolated modules.
TEXT,
                'target_keywords' => ['manufacturing BOM software', 'production inventory software', 'actual material consumption', 'production costing software', 'manufacturing inventory system'],
                'related_product_slugs' => ['erp', 'raw-materials-db', 'pvc-pipe-factory'],
                'faq' => [
                    ['question' => 'Should actual consumption overwrite the BOM?', 'answer' => 'No. The BOM is the planning baseline while actual consumption records what production really used. Keeping both allows variance analysis.'],
                    ['question' => 'How should production affect inventory?', 'answer' => 'Approved actual material consumption should create traceable stock deductions, while completed output creates the corresponding finished-goods receipt.'],
                    ['question' => 'Can manufacturing software compare standard and realized cost?', 'answer' => 'Yes. Planned BOM cost and actual production cost can remain separate so management can measure material and process variance.'],
                ],
                'meta_title' => 'Manufacturing Inventory & BOM Software | BusinessOS',
                'meta_description' => 'Manufacturing software for BOM planning, actual material consumption, production inventory, variance and realized production costing.',
            ],
            [
                'title' => 'Field Sales Visit Management Software',
                'slug' => 'field-sales-visit-management-software',
                'eyebrow' => 'Field sales operations',
                'headline' => 'Field sales software that connects territories, customer visits, orders, collections and follow-up.',
                'excerpt' => 'Give supervisors a clear view of assigned customers, planned visits, field activity and commercial outcomes without reducing performance to GPS points.',
                'content' => <<<'TEXT'
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
TEXT,
                'target_keywords' => ['field sales visit management', 'salesman visit tracking', 'field sales software', 'territory management software', 'customer visit app'],
                'related_product_slugs' => ['fieldpulse'],
                'faq' => [
                    ['question' => 'What is field sales visit management software?', 'answer' => 'It organizes assigned customers, territories, planned visits, visit outcomes, orders, collections and follow-up for employees working outside the office.'],
                    ['question' => 'Should field sales software track GPS all day?', 'answer' => 'Not necessarily. Location is most useful when tied to business events such as customer check-ins, territory coverage and visit validation.'],
                    ['question' => 'Can field visit software work offline?', 'answer' => 'Yes. Assigned data and permitted transactions can be kept locally and synchronized when connectivity returns.'],
                ],
                'meta_title' => 'Field Sales Visit Management Software | BusinessOS',
                'meta_description' => 'Field sales software for territories, customer assignments, visit planning, geofenced check-ins, orders, collections, follow-up and offline mobile work.',
            ],
            [
                'title' => 'Restaurant Waiter Ordering & KOT Software',
                'slug' => 'restaurant-waiter-ordering-kot-software',
                'eyebrow' => 'Restaurant table operations',
                'headline' => 'Restaurant software that connects waiter table orders to kitchen stations, KOT workflow and cashier billing.',
                'excerpt' => 'Let waiters take table orders on mobile, route items to preparation stations and keep kitchen events connected to the final bill.',
                'content' => <<<'TEXT'
Restaurant ordering software should reduce verbal coordination without making the waiter responsible for managing kitchen routing manually.

## Let the waiter focus on the table

The waiter mobile app should make it quick to select the table, add menu items, quantities, modifiers and notes, then submit the order.

The system should preserve who entered the order and when it was submitted.

## Route each item to the correct station

Menu items can be assigned to preparation stations such as grill, main kitchen, drinks or desserts. When the waiter submits the order, each station receives only the items it needs to prepare.

This can be delivered through printed Kitchen Order Tickets, kitchen display screens or both.

## Preserve additions, voids and changes

If the table orders more items later, the kitchen should receive a clear incremental ticket rather than an ambiguous copy of the original order.

Voids and cancellations should remain traceable and can require approval based on restaurant policy.

## Show preparation progress

Statuses such as new, preparing and ready can help the waiter understand progress without repeatedly asking kitchen staff.

For multi-station orders, the restaurant can define when the overall order is considered ready.

## Keep kitchen and cashier records connected

The order that reaches the kitchen should remain the same commercial record that later becomes the customer bill. Split bills, discounts, complimentary items, payments and closing should be traceable back to the table order.

BusinessOS restaurant management is designed for internal waiter ordering and restaurant operations, not public customer self-ordering.
TEXT,
                'target_keywords' => ['restaurant waiter ordering software', 'KOT software', 'restaurant kitchen display', 'table ordering app for waiters', 'restaurant billing software'],
                'related_product_slugs' => ['restaurant-management', 'pos'],
                'faq' => [
                    ['question' => 'Is this customer self-ordering software?', 'answer' => 'No. The BusinessOS workflow is designed for waiters to take and manage table orders inside the restaurant.'],
                    ['question' => 'What is a KOT in restaurant software?', 'answer' => 'A Kitchen Order Ticket communicates ordered items, quantities, modifiers, notes, table and timing information to the relevant preparation station.'],
                    ['question' => 'Can different menu items go to different kitchen stations?', 'answer' => 'Yes. Menu items can be assigned to preparation stations so each station receives the part of the order it needs to prepare.'],
                ],
                'meta_title' => 'Waiter Ordering & Restaurant KOT Software | BusinessOS',
                'meta_description' => 'Restaurant waiter ordering software with mobile table orders, kitchen station routing, KOT workflow, preparation status, cashier billing and closing.',
            ],
            [
                'title' => 'Dari & Pashto Business Software',
                'slug' => 'dari-pashto-business-software',
                'eyebrow' => 'Multilingual business systems',
                'headline' => 'Business software with English, Dari and Pashto interfaces designed for real multilingual operations.',
                'excerpt' => 'Build ERP, POS, field sales and operational systems with proper RTL behavior, translated workflows and language-aware user experience.',
                'content' => <<<'TEXT'
Multilingual business software needs more than translated labels. The interface, layout, terminology and operational meaning all need to remain clear when users switch between English, Dari and Pashto.

## Treat RTL as part of the interface

Dari and Pashto use right-to-left writing. Navigation, forms, tables, icons and directional controls need to behave correctly when the interface changes direction.

A page that simply aligns paragraphs to the right can still feel broken if the rest of the interaction remains designed only for left-to-right use.

## Translate business meaning, not just words

Operational terms such as invoice, collection, warehouse, stock transfer, production completion or daily closing need consistent translations across the application.

Different screens should not use different words for the same business action.

## Keep data language separate from interface language

The interface may be Dari while customer names, product codes or imported data remain in another language. The system should support Unicode data consistently and avoid forcing records to match the selected interface language.

## Design reports and printouts deliberately

Invoices, quotations, receipts and reports may need different language requirements from the application itself. A business can choose whether printouts follow the user's language, customer preference or a fixed company standard.

## Preserve performance

Language switching should not require loading a separate heavy application. Translation resources can be structured so the system remains responsive on slower networks.

BusinessOS products can support English, Dari and Pashto with RTL-aware interfaces while keeping the same underlying business rules and data.
TEXT,
                'target_keywords' => ['Dari business software', 'Pashto business software', 'multilingual ERP', 'Dari POS software', 'Pashto POS software'],
                'related_product_slugs' => ['erp', 'pos', 'fieldpulse', 'pharmacy-management', 'restaurant-management'],
                'faq' => [
                    ['question' => 'Does multilingual software need separate databases for each language?', 'answer' => 'No. The interface translations can change while the business records remain in one shared data model.'],
                    ['question' => 'What does RTL support require?', 'answer' => 'Proper RTL support covers layout direction, navigation, forms, tables, spacing, icons and printed output where applicable, not only text alignment.'],
                    ['question' => 'Can users switch between English, Dari and Pashto?', 'answer' => 'Yes. A multilingual application can preserve the same business records and permissions while each user works in a supported interface language.'],
                ],
                'meta_title' => 'Dari & Pashto Business Software | BusinessOS',
                'meta_description' => 'Multilingual ERP, POS and business software with English, Dari and Pashto interfaces, proper RTL behavior and shared operational data.',
            ],
        ];
    }

    private function guides(): array
    {
        return [
            [
                'title' => 'How Offline-First Business Software Works on Poor Internet',
                'slug' => 'offline-first-business-software-poor-internet',
                'category' => 'Offline-First Software',
                'excerpt' => 'Understand local data, transaction queues, synchronization, conflict handling and user feedback in software designed for unreliable connectivity.',
                'content' => <<<'TEXT'
Offline-first software is designed around the assumption that connectivity will sometimes disappear.

## Decide what must remain usable

The first step is to list the actions that cannot stop when the network fails. For a field-sales app this may include opening assigned customers, checking in, taking an order and recording a collection. For a retail system it may be checkout.

Features that are not time-critical can remain online.

## Store only the data the user needs

The device should receive the minimum data set required for offline work. A salesman may need assigned customers and a product catalog, while a cashier may need products, prices and local selling rules.

Smaller local data sets synchronize faster and reduce unnecessary exposure.

## Queue writes with stable identifiers

Every offline transaction needs a local identifier. When the network returns, the application retries the same transaction rather than creating a new one each time.

The server should treat retries idempotently so a repeated request cannot create duplicate orders or payments.

## Show synchronization state

Users should be able to distinguish saved locally, synchronizing, synchronized and rejected transactions. Hiding synchronization status creates uncertainty about whether work reached the server.

## Resolve conflicts deliberately

Different data types need different rules. Notes may merge easily. Stock, payment and financial records may require server validation before they become final.

## Test real network failure

Offline mode should be tested by actually disconnecting the device, closing and reopening the app, creating several transactions, restoring connectivity and confirming that records synchronize once and in the correct order.

Offline-first quality is defined by recovery from failure, not by how the application behaves on perfect Wi-Fi.
TEXT,
                'meta_title' => 'Offline-First Software on Poor Internet: How It Works | BusinessOS',
                'meta_description' => 'Learn how offline-first business apps use local data, queues, idempotent sync, conflict handling and clear status to work through unreliable internet.',
            ],
            [
                'title' => 'Supermarket POS Buying Checklist',
                'slug' => 'supermarket-pos-buying-checklist',
                'category' => 'Retail POS',
                'excerpt' => 'A practical checklist for evaluating supermarket POS software across checkout speed, inventory, cashier control, closing, reporting and connectivity.',
                'content' => <<<'TEXT'
A supermarket POS should be evaluated from the checkout counter backward.

## Checkout speed

Test how quickly a cashier can search for products, change quantity, apply an allowed discount, take payment and complete the sale.

A system with many features can still fail if everyday checkout is slow.

## Product and price control

Check how products, units and selling prices are maintained. Price changes should be controlled and should reach the correct branch or device reliably.

## Inventory movement

Completed sales, returns and approved voids should have clear stock effects. Management should be able to explain stock through transaction history rather than only seeing the current balance.

## Cashier shifts and daily closing

Ask how the system records shift opening, expected cash, confirmed cash and closing variance.

A sales report is not the same as cashier accountability.

## Permissions and audit history

Review who can discount, void, change price, reopen a shift or adjust stock. Sensitive actions should remain traceable.

## Connectivity model

If internet service is unreliable, test what happens when the connection disappears during checkout. The vendor should be able to explain exactly which actions continue and how data synchronizes later.

## Back-office growth

Consider whether the business may later need purchasing, warehouse transfers, supplier balances, expenses, accounting or multiple branches.

The POS does not need to show all of those functions to the cashier, but the wider architecture should not block future growth.
TEXT,
                'meta_title' => 'Supermarket POS Buying Checklist: What to Evaluate | BusinessOS',
                'meta_description' => 'Use this supermarket POS checklist to compare checkout speed, stock control, cashier shifts, closing, permissions, offline behavior and back-office needs.',
            ],
            [
                'title' => 'Pharmacy Stock, Expiry and Reorder Guide',
                'slug' => 'pharmacy-stock-expiry-reorder-guide',
                'category' => 'Pharmacy Operations',
                'excerpt' => 'Connect medicine batches, expiry dates, movement history and replenishment so pharmacy purchasing decisions use usable stock instead of quantity alone.',
                'content' => <<<'TEXT'
Pharmacy replenishment should not look only at the total quantity of a medicine.

## Separate usable stock from risky stock

A medicine may show a positive balance while a large part of that balance is near expiry. Reorder decisions should distinguish stock that is likely to sell normally from stock that needs urgent attention.

## Capture batches at receiving

Batch and expiry information should enter the system when stock is received. This gives later reports a reliable source record.

## Review movement history

Fast-moving and slow-moving medicines should not use the same reorder assumptions. Historical issue or sales quantity can help the pharmacy estimate how quickly stock is likely to move.

## Add a reorder threshold

A reorder level can combine minimum operating quantity, lead time and expected movement. The exact formula depends on the pharmacy, but the rule should be visible rather than hidden in staff memory.

## Include near-expiry exposure

If a medicine is below the normal reorder level but the remaining stock will expire before expected use, the purchasing decision may need to consider replacement timing and supplier options.

## Keep adjustments traceable

Damaged, expired, returned and corrected quantities should use explicit transactions so the system can explain why the balance changed.

The goal is to make purchasing decisions from stock that is both physically available and operationally usable.
TEXT,
                'meta_title' => 'Pharmacy Stock, Expiry & Reorder Guide | BusinessOS',
                'meta_description' => 'Learn how medicine batches, expiry dates, stock movement and reorder levels work together for safer pharmacy inventory decisions.',
            ],
            [
                'title' => 'Manufacturing BOM and Production Costing Guide',
                'slug' => 'manufacturing-bom-costing-guide',
                'category' => 'Manufacturing',
                'excerpt' => 'A practical guide to standard BOM quantities, actual consumption, stock deduction, variance and realized production cost.',
                'content' => <<<'TEXT'
Manufacturing costing becomes clearer when planning and execution are stored separately.

## Standard BOM

The standard BOM defines expected material usage for a product or production quantity. It supports planning and standard cost.

## Production plan

A production order can scale the BOM to the quantity being produced and reserve or request the required materials.

## Actual consumption

Production staff record what was actually consumed. The actual quantity should not overwrite the standard because the difference is useful management information.

## Inventory posting

Approved actual consumption creates stock deductions tied to the production transaction. Completed output creates the finished-goods receipt.

## Realized material cost

The system applies the relevant inventory cost to the actual quantities used. Additional approved production costs can then be included according to the company's costing policy.

## Variance analysis

Material quantity variance shows where real usage differs from standard. Repeated variance may indicate waste, process instability or an outdated BOM.

## Quotation versus production cost

A quotation may use standard assumptions while realized production cost uses actual approved consumption. Keeping both numbers allows the business to compare expected and realized margin.

The strongest costing system preserves the path from standard recipe to production execution instead of replacing one number with another.
TEXT,
                'meta_title' => 'Manufacturing BOM & Production Costing Guide | BusinessOS',
                'meta_description' => 'Understand standard BOM, actual consumption, inventory posting, production variance and realized cost in manufacturing software.',
            ],
            [
                'title' => 'How to Plan Field Sales Visits and Territories',
                'slug' => 'field-sales-visit-planning-territories',
                'category' => 'Field Sales',
                'excerpt' => 'Structure territories, customer assignments and visit plans so field teams know what to do and supervisors can measure coverage and outcomes.',
                'content' => <<<'TEXT'
A field-sales visit plan is useful only when it reflects clear responsibility.

## Define territories before optimizing routes

A territory can be geographic, customer-based or business-rule based. The important point is that management can explain which salesman is responsible for which customers.

Map drawing can make geographic territories easier to create than entering coordinates manually.

## Assign customers explicitly

A customer should have a clear assignment history. Referral relationships can be stored separately from current sales responsibility so the system does not confuse who introduced the customer with who manages the account today.

## Build the visit plan

The plan can combine required visit frequency, customer priority, route practicality and overdue follow-up.

Not every customer needs the same visit cycle.

## Give the salesman a focused mobile list

The mobile application should show today's assigned work, customer location, recent history and outstanding follow-up without forcing the salesman to search through the entire customer database.

## Capture outcomes

Completed visit, no-contact, order, collection, note and next follow-up should remain attached to the customer record.

## Measure coverage with results

Managers can review planned versus completed visits, customers not visited, orders, collections and overdue follow-ups by salesman or territory.

Territory software is strongest when it helps explain both coverage and commercial outcomes.
TEXT,
                'meta_title' => 'Field Sales Visit Planning & Territory Management Guide | BusinessOS',
                'meta_description' => 'Learn how to structure territories, customer assignments, visit plans, mobile worklists, outcomes and coverage reporting for field sales teams.',
            ],
            [
                'title' => 'Restaurant Table Order to Kitchen and Billing Workflow',
                'slug' => 'restaurant-table-order-kitchen-billing-workflow',
                'category' => 'Restaurant Operations',
                'excerpt' => 'Follow the complete restaurant order lifecycle from waiter entry through kitchen stations, additions, voids, preparation, bill and cashier closing.',
                'content' => <<<'TEXT'
A restaurant order should remain one connected record from the table to the final payment.

## Waiter entry

The waiter selects the table and adds menu items, quantities, modifiers and notes through the mobile application.

## Kitchen routing

When the order is submitted, the system routes each item to its configured preparation station. Kitchen staff receive a KOT or display ticket containing the information needed to prepare the item.

## Additions

If the guest adds another item later, the new item should be sent as an addition rather than reprinting the entire original order without explanation.

## Voids and cancellations

Removed items should remain in history with reason and approval where required. This protects both kitchen coordination and cashier accountability.

## Preparation state

Stations can move items through statuses such as new, preparing and ready. Waiters can see progress without repeatedly interrupting the kitchen.

## Billing

The final bill should use the same table order. Discounts, split payments, complimentary items and settlement remain tied to the operational history.

## Closing

Cashier or shift closing compares expected payments with confirmed amounts and preserves any difference for review.

A connected restaurant workflow reduces duplicate entry and makes it much easier to investigate missing items, voids and payment differences.
TEXT,
                'meta_title' => 'Restaurant Order, KOT, Kitchen & Billing Workflow | BusinessOS',
                'meta_description' => 'See how waiter table orders should connect to kitchen stations, KOTs, additions, voids, preparation status, billing and cashier closing.',
            ],
            [
                'title' => 'Designing Business Software for English, Dari and Pashto',
                'slug' => 'multilingual-business-software-dari-pashto',
                'category' => 'Multilingual Software',
                'excerpt' => 'A practical guide to RTL layout, terminology, shared business data and printouts when building software for English, Dari and Pashto users.',
                'content' => <<<'TEXT'
Multilingual business software has two separate responsibilities: interface language and business data.

## Keep one operational data model

Customers, products, invoices and transactions do not need separate databases because the interface language changes. The system can store one business record while users work in different supported languages.

## Design RTL instead of patching it

Dari and Pashto need right-to-left layout behavior. Navigation order, form spacing, tables, directional icons, breadcrumbs and mobile drawers all need testing in RTL mode.

## Create a terminology glossary

Business terms should be translated consistently across modules. A glossary for inventory, finance, sales and workflow actions reduces confusion when several translators or developers work on the system.

## Decide how printouts choose language

Receipts, invoices and quotations may follow the current user's language, a customer preference or a company-wide standard. The rule should be explicit.

## Keep codes language-neutral where possible

Product codes, account numbers and document numbers are usually easier to integrate when their underlying identifiers are language-neutral, even when labels are translated.

## Test with real content

RTL layouts should be tested with real Dari and Pashto sentences, long customer names, numbers, mixed Latin codes and tables. Placeholder text often hides layout problems.

Good multilingual software lets language change without changing the meaning of the workflow.
TEXT,
                'meta_title' => 'English, Dari & Pashto Business Software Design Guide | BusinessOS',
                'meta_description' => 'Learn how to design multilingual business software with RTL layouts, consistent terminology, shared data and language-aware printouts for Dari and Pashto.',
            ],
        ];
    }
}
