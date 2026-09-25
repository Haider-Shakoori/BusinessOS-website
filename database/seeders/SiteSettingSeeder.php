<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'brand' => [
                'brand_name' => 'BusinessOS',
                'brand_tagline' => 'Modern software. Serious engineering. Fast everywhere.',
                'footer_text' => 'Focused business software for teams that value clarity, speed and practical workflows.',
                'footer_text_fa' => 'نرم‌افزارهای متمرکز تجاری برای تیم‌هایی که به وضوح، سرعت و روندهای عملی اهمیت می‌دهند.',
                'footer_text_ps' => 'د هغو ټیمونو لپاره متمرکز سوداګریز سافټویر چې روښانتیا، چټکتیا او عملي کاري بهیرونو ته ارزښت ورکوي.',
            ],
            'navigation' => [
                'nav_products_label' => 'Products',
                'nav_solutions_label' => 'Solutions',
                'nav_pricing_label' => 'Pricing',
                'nav_resources_label' => 'Resources',
                'nav_company_label' => 'Company',
                'nav_demo_label' => 'Request a demo',
            ],
            'homepage' => [
                'homepage_hero_eyebrow' => 'BusinessOS software ecosystem',
                'homepage_hero_title' => 'Software for the way your business actually runs.',
                'homepage_hero_description' => 'BusinessOS brings focused software for field sales, business management and retail operations under one product family—built for practical work, local realities and modern teams.',
                'homepage_hero_title_fa' => 'نرم‌افزار برای شیوه‌ای که کسب‌وکار شما واقعاً کار می‌کند.',
                'homepage_hero_description_fa' => 'BusinessOS نرم‌افزارهای تخصصی برای فروش ساحوی، مدیریت تجارت و عملیات فروشگاهی را در یک خانواده محصول گردهم می‌آورد.',
                'homepage_hero_title_ps' => 'ستاسو د سوداګرۍ د واقعي کار لپاره سافټویر.',
                'homepage_hero_description_ps' => 'BusinessOS د ساحوي پلور، سوداګرۍ مدیریت او پرچون عملیاتو لپاره متمرکز سافټویرونه په یوه محصولي کورنۍ کې راټولوي.',
                'homepage_apps_title' => 'Focused products for different parts of the business.',
                'homepage_apps_description' => 'Use the product that matches the workflow. BusinessOS keeps each application focused instead of forcing every team into one oversized interface.',
                'homepage_solutions_title' => 'Different teams. One clear software direction.',
                'homepage_solutions_description' => 'BusinessOS is designed around the work happening in the field, the back office and the shop floor.',
                'homepage_why_title' => 'One brand. Clear products. Practical software.',
                'homepage_why_description' => 'BusinessOS is the master platform and product family. Each application solves a specific operational problem while following the same approach to clarity, responsiveness and maintainability.',
                'homepage_engineering_title' => 'Modern on the surface. Practical underneath.',
                'homepage_engineering_description' => 'BusinessOS products are built around responsive interfaces, maintainable application architecture and performance that remains useful on real devices and imperfect networks.',
                'homepage_resources_title' => 'Useful ideas for running better operations.',
                'homepage_final_title' => 'Find the right product for the part of your business you want to improve.',
                'homepage_final_description' => 'Explore FieldPulse, ERP and POS, or tell us about the workflow you need to improve and choose the product from the demo form.',
            ],
            'about' => [
                'about_title' => 'Software shaped around the way businesses actually operate.',
                'about_lead' => 'BusinessOS is a growing software ecosystem focused on practical business workflows: sales, field operations, ERP, retail, automation and analytics.',
                'about_body' => 'BusinessOS applications are built around clear operational problems. Each product can stand on its own while sharing a consistent approach to usability, performance, security and long-term maintainability.',
                'about_title_fa' => 'نرم‌افزاری که مطابق شیوه واقعی فعالیت کسب‌وکارها ساخته شده است.',
                'about_lead_fa' => 'BusinessOS یک اکوسیستم رو‌به‌رشد نرم‌افزاری برای روندهای عملی تجارت است.',
                'about_body_fa' => 'برنامه‌های BusinessOS بر اساس مشکلات روشن عملیاتی ساخته می‌شوند و یک رویکرد مشترک در استفاده‌پذیری، سرعت، امنیت و نگهداری دارند.',
                'about_title_ps' => 'سافټویر چې د سوداګرۍ د واقعي فعالیت له مخې جوړ شوی.',
                'about_lead_ps' => 'BusinessOS د عملي سوداګریزو کاري بهیرونو لپاره د سافټویرونو وده کوونکی اکوسیستم دی.',
                'about_body_ps' => 'د BusinessOS اپونه د روښانه عملیاتي ستونزو پر بنسټ جوړېږي او د کارونې، چټکتیا، امنیت او ساتنې ګډه تګلاره لري.',
            ],
            'contact' => [
                'contact_email' => '',
                'contact_phone' => '',
                'contact_address' => 'Afghanistan',
            ],
            'seo' => [
                'seo_default_title' => 'BusinessOS — Business Software for Field Sales, ERP & Retail',
                'seo_default_description' => 'BusinessOS builds practical software for field sales, ERP, retail operations and business management.',
                'og_image' => '',
            ],
        ];

        foreach ($groups as $group => $settings) {
            foreach ($settings as $key => $value) {
                SiteSetting::firstOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => $value]
                );
            }
        }
    }
}
