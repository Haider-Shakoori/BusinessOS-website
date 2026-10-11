<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->replaceUneditedDefault($this->originalContent(), $this->enhancedContent());
    }

    public function down(): void
    {
        $this->replaceUneditedDefault($this->enhancedContent(), $this->originalContent());
    }

    private function replaceUneditedDefault(string $expected, string $replacement): void
    {
        $guide = DB::table('guides')->where('slug', 'manufacturing-bom-costing-guide')->first();

        // Never replace text that an editor has already changed in the CMS.
        if (! $guide || trim((string) $guide->content) !== trim($expected)) {
            return;
        }

        DB::table('guides')
            ->where('id', $guide->id)
            ->where('content', $guide->content)
            ->update(['content' => $replacement, 'updated_at' => now()]);
    }

    private function originalContent(): string
    {
        return <<<'TEXT'
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
TEXT;
    }

    private function enhancedContent(): string
    {
        return <<<'TEXT'
Manufacturing costing becomes clearer when standard quantities, actual consumption and stock valuation are kept as separate records. A bill of materials (BOM) is a planning assumption; a posted production transaction should describe what actually happened.

## Start with a measurable standard BOM

Specify each material, its unit and expected quantity per finished item or batch. For a carton, that may include paper layers, adhesive and other consumables. State whether normal process waste is included in the standard. Keep units consistent: grams per carton, kilograms per batch and prices per kilogram must be converted explicitly.

## Worked example: 1,000 cartons

The following figures are illustrative, not a published customer result. Assume the standard recipe is 0.120 kg of paper and 0.006 kg of adhesive for one carton. A plan for 1,000 cartons therefore requires 120 kg of paper and 6 kg of adhesive.

At hypothetical rates of AFN 75 per kg of paper and AFN 40 per kg of adhesive, the standard direct-material cost is (120 × 75) + (6 × 40) = AFN 9,240, or AFN 9.24 per carton.

Now assume the factory records actual use of 125 kg of paper and 6.5 kg of adhesive to complete all 1,000 cartons. At those same rates, the realized direct-material cost is (125 × 75) + (6.5 × 40) = AFN 9,635, or AFN 9.635 per carton. The AFN 395 unfavorable difference is a quantity-usage variance in this example; it is not automatically a purchasing-price variance or a loss of AFN 395 in accounting profit.

## Post actual inventory movement, not the quotation estimate

Production staff should capture approved quantities for the batch. Inventory deduction must use the actual stock items and units, with a traceable production reference. A finished-goods receipt records completed output separately. If material is returned unused, rejected or scrapped, record that explicitly so it is not deducted twice.

Where paper rolls cannot be weighed on site, a validated consumption estimate based on produced quantity, carton weight, reel dimensions or production records may be necessary. Label such postings as estimates, establish a documented conversion method and reconcile them against periodic physical stock counts. Do not present an estimated deduction as independently measured consumption.

## Separate quantity variance from price variance

If the purchase rate also changes, calculate a separate price effect instead of blaming every difference on production wastage. Compare planned and actual quantities at a common cost rate to understand usage; compare actual inventory rates with the assumed rate to understand valuation differences.

For example, the AFN 395 variance above assumes unchanged material rates. With a new paper price, the total gap combines both material usage and rate changes.

## Add labor and overhead deliberately

Direct material cost alone is not total production cost. Approved labor, power, machine time, freight or other overhead may also belong in costing depending on the documented company policy. Avoid counting waste twice if it was already built into the standard quantities and again recorded as extra consumption.

## Reconcile quotation, execution and finished stock

A quotation may price the job from a standard BOM plus commercial markup. Production planning uses the same standard to reserve expected materials. The final batch then records actual consumption, accepted output, rejected quantities and realized cost.

Compare the planned amount, actual stock movement and recorded finished quantity before closing production. If 1,000 cartons were planned but only 960 accepted, cost per accepted carton changes even when raw material usage is unchanged. Keep the audit path from quotation to BOM revision to production to inventory posting and financial review.

Use recurring differences to improve the standard BOM; do not silently overwrite earlier production history when the standard is revised.
TEXT;
    }

};
