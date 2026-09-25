# Restaurant Management System — Product Specification Baseline

Status: planned BusinessOS product. This document is the durable baseline for future implementation work.

## Product intent

This is an **internal restaurant operations system**. It is not a customer self-ordering application.

The mobile application is used by **restaurant waiters** while serving tables. Waiters select a table, enter the guests' order, add notes/modifiers and submit the order. The order flows into the restaurant dashboard and the correct kitchen/preparation station.

## Primary users

- Waiter
- Cashier
- Kitchen / preparation staff
- Supervisor / restaurant manager
- Administrator / owner

## Core waiter workflow

1. Waiter starts or joins a shift.
2. Waiter opens/selects a table.
3. Waiter browses the current restaurant menu.
4. Waiter adds items, quantities, modifiers and preparation notes.
5. Waiter submits the order.
6. Items are routed to the relevant kitchen/preparation station.
7. Kitchen receives the order through a Kitchen Display System (KDS), printed KOT, or both.
8. Kitchen moves items/orders through preparation statuses.
9. Waiter sees when items are ready and serves the table.
10. Waiter can add additional items to the same open table.
11. Table can be transferred or merged if guests move.
12. At settlement, the bill can remain whole or be split.
13. Cashier records one or multiple payments.
14. Table/order is closed after settlement.

## Required modules and controls

### Waiter mobile application
- Secure waiter login
- Shift context
- Table selection
- Live menu
- Categories
- Item variants/modifiers/add-ons
- Item notes
- Quantity changes
- Submit new order
- Add items to existing order
- View kitchen/order status
- Permission-aware cancellations/void requests

### Table management
- Restaurant areas/floors
- Table master
- Occupied / available / reserved-style operational states where required
- Active table order
- Waiter assignment
- Transfer active table/order
- Merge tables/orders
- Preserve audit history when transferred or merged

### Kitchen workflow
- Kitchen/preparation stations
- Item-to-station routing
- Kitchen Display System
- Printed Kitchen Order Ticket (KOT)
- New / accepted / preparing / ready / served / completed / cancelled states
- Preparation notes
- Reprints with audit trail
- Station-specific views

### Billing and settlement
- Generate bill from active table order
- Split bill by item
- Split bill by guest
- Split bill by amount
- Multiple payment methods on one bill
- Approved discounts
- Bill adjustments with permissions
- Reprint bill/receipt
- Close table only after settlement or authorized override

### Waiter shifts
- Open/close waiter shift
- Orders linked to waiter and shift
- Sales/activity by waiter
- Order changes linked to responsible user
- Void/cancellation requests linked to waiter

### Cashier shifts and closing
- Cashier shift open
- Opening cash where required
- Expected cash
- Counted cash
- Card/other payment totals
- Discounts
- Voids/cancellations
- Complimentary items
- Refunds where implemented
- Closing variance
- Closing report
- Supervisor approval where required

### Approval and audit controls
- Void item approval
- Void order approval
- Cancellation reason
- Complimentary item approval
- Discount authorization
- Sensitive price/bill adjustment authorization
- User, timestamp and reason audit history
- Prevent silent deletion of chargeable activity

### Menu management
- Categories
- Menu items
- Prices
- Variants
- Modifiers
- Add-ons
- Kitchen station assignment
- Temporary availability / sold-out state
- Central updates reflected on waiter devices

### Reporting
- Sales by day/shift
- Sales by waiter
- Sales by item/category
- Popular items
- Table turnover
- Order preparation time where data is available
- Discounts
- Voids/cancellations
- Complimentary items
- Cashier closing
- Closing variance
- Payment-method totals
- Kitchen/station operational metrics where useful

## Product boundary

The waiter mobile application is **not intended for customers to place orders themselves**. Future customer-facing ordering should be treated as a separate optional product/module and must not be assumed as part of this baseline.

## Future implementation principle

When development begins, preserve this workflow as the functional source of truth unless the requirement is explicitly changed.
