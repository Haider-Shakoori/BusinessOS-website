<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $this->replaceDefaults([
            'homepage_hero_eyebrow' => [
                'BusinessOS software ecosystem',
                'Business software & custom development',
            ],
            'homepage_hero_title' => [
                'Software for the way your business actually runs.',
                'Build, modernize and run your business with better software.',
            ],
            'homepage_hero_description' => [
                'BusinessOS brings focused software for field sales, business management and retail operations under one product family—built for practical work, local realities and modern teams.',
                'BusinessOS builds websites, custom ERP and MIS systems, web applications and industry software—plus data migration, integrations and application upgrades for businesses that need technology matched to real workflows.',
            ],
            'homepage_final_description' => [
                'Explore FieldPulse, ERP and POS, or tell us about the workflow you need to improve and choose the product from the demo form.',
                'Explore BusinessOS products or tell us about the workflow, website, system, data migration or modernization project you need to improve.',
            ],
            'seo_default_title' => [
                'BusinessOS — Business Software for Field Sales, ERP & Retail',
                'BusinessOS — Website Development, Custom ERP, MIS & Business Software',
            ],
            'seo_default_description' => [
                'BusinessOS builds practical software for field sales, ERP, retail operations and business management.',
                'BusinessOS provides website development, custom ERP and MIS, web applications, data migration, application upgrades, integrations and industry-specific business software.',
            ],
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $this->replaceDefaults([
            'homepage_hero_eyebrow' => ['Business software & custom development', 'BusinessOS software ecosystem'],
            'homepage_hero_title' => ['Build, modernize and run your business with better software.', 'Software for the way your business actually runs.'],
            'homepage_hero_description' => ['BusinessOS builds websites, custom ERP and MIS systems, web applications and industry software—plus data migration, integrations and application upgrades for businesses that need technology matched to real workflows.', 'BusinessOS brings focused software for field sales, business management and retail operations under one product family—built for practical work, local realities and modern teams.'],
            'homepage_final_description' => ['Explore BusinessOS products or tell us about the workflow, website, system, data migration or modernization project you need to improve.', 'Explore FieldPulse, ERP and POS, or tell us about the workflow you need to improve and choose the product from the demo form.'],
            'seo_default_title' => ['BusinessOS — Website Development, Custom ERP, MIS & Business Software', 'BusinessOS — Business Software for Field Sales, ERP & Retail'],
            'seo_default_description' => ['BusinessOS provides website development, custom ERP and MIS, web applications, data migration, application upgrades, integrations and industry-specific business software.', 'BusinessOS builds practical software for field sales, ERP, retail operations and business management.'],
        ]);
    }

    private function replaceDefaults(array $values): void
    {
        foreach ($values as $key => [$from, $to]) {
            DB::table('site_settings')
                ->where('key', $key)
                ->where('value', $from)
                ->update([
                    'value' => $to,
                    'updated_at' => now(),
                ]);
        }
    }
};
