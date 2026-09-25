<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(private readonly SiteSettings $settings) {}

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => $this->settings->all(),
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach ($this->fields() as $group => $fields) {
            foreach ($fields as $key => $field) {
                $rules[$key] = ['nullable', 'string', 'max:'.($field['max'] ?? 5000)];
            }
        }

        $data = $request->validate($rules);

        foreach ($this->fields() as $group => $fields) {
            foreach ($fields as $key => $field) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => trim((string) ($data[$key] ?? ''))]
                );
            }
        }

        $this->settings->forget();

        return back()->with('status', 'Website settings updated.');
    }

    private function fields(): array
    {
        return [
            'brand' => [
                'brand_name' => ['label' => 'Brand name', 'default' => 'BusinessOS', 'max' => 190],
                'brand_tagline' => ['label' => 'Brand tagline', 'default' => 'Modern software. Serious engineering. Fast everywhere.', 'max' => 255],
                'footer_text' => ['label' => 'Footer description', 'default' => 'Focused business software for teams that value clarity, speed and practical workflows.'],
                'footer_text_fa' => ['label' => 'Footer description — Dari', 'default' => 'نرم‌افزارهای متمرکز تجاری برای تیم‌هایی که به وضوح، سرعت و روندهای عملی اهمیت می‌دهند.'],
                'footer_text_ps' => ['label' => 'Footer description — Pashto', 'default' => 'د هغو ټیمونو لپاره متمرکز سوداګریز سافټویر چې روښانتیا، چټکتیا او عملي کاري بهیرونو ته ارزښت ورکوي.'],
            ],
            'navigation' => [
                'nav_products_label' => ['label' => 'Products label', 'default' => 'Products', 'max' => 80],
                'nav_solutions_label' => ['label' => 'Solutions label', 'default' => 'Solutions', 'max' => 80],
                'nav_pricing_label' => ['label' => 'Pricing label', 'default' => 'Pricing', 'max' => 80],
                'nav_resources_label' => ['label' => 'Resources label', 'default' => 'Resources', 'max' => 80],
                'nav_company_label' => ['label' => 'Company label', 'default' => 'Company', 'max' => 80],
                'nav_demo_label' => ['label' => 'Primary CTA label', 'default' => 'Request a demo', 'max' => 120],
            ],
            'homepage' => [
                'homepage_hero_eyebrow' => ['label' => 'Hero eyebrow', 'default' => 'BusinessOS software ecosystem', 'max' => 190],
                'homepage_hero_title' => ['label' => 'Hero title', 'default' => 'Software for the way your business actually runs.', 'max' => 300],
                'homepage_hero_description' => ['label' => 'Hero description', 'default' => 'BusinessOS brings focused software for field sales, business management and retail operations under one product family—built for practical work, local realities and modern teams.'],
                'homepage_hero_title_fa' => ['label' => 'Hero title — Dari', 'default' => 'نرم‌افزار برای شیوه‌ای که کسب‌وکار شما واقعاً کار می‌کند.', 'max' => 300],
                'homepage_hero_description_fa' => ['label' => 'Hero description — Dari', 'default' => 'BusinessOS نرم‌افزارهای تخصصی برای فروش ساحوی، مدیریت تجارت و عملیات فروشگاهی را در یک خانواده محصول گردهم می‌آورد.'],
                'homepage_hero_title_ps' => ['label' => 'Hero title — Pashto', 'default' => 'ستاسو د سوداګرۍ د واقعي کار لپاره سافټویر.', 'max' => 300],
                'homepage_hero_description_ps' => ['label' => 'Hero description — Pashto', 'default' => 'BusinessOS د ساحوي پلور، سوداګرۍ مدیریت او پرچون عملیاتو لپاره متمرکز سافټویرونه په یوه محصولي کورنۍ کې راټولوي.'],
                'homepage_apps_title' => ['label' => 'Apps section title', 'default' => 'Focused products for different parts of the business.'],
                'homepage_apps_description' => ['label' => 'Apps section description', 'default' => 'Use the product that matches the workflow. BusinessOS keeps each application focused instead of forcing every team into one oversized interface.'],
                'homepage_solutions_title' => ['label' => 'Solutions section title', 'default' => 'Different teams. One clear software direction.'],
                'homepage_solutions_description' => ['label' => 'Solutions section description', 'default' => 'BusinessOS is designed around the work happening in the field, the back office and the shop floor.'],
                'homepage_why_title' => ['label' => 'Why BusinessOS title', 'default' => 'One brand. Clear products. Practical software.'],
                'homepage_why_description' => ['label' => 'Why BusinessOS description', 'default' => 'BusinessOS is the master platform and product family. Each application solves a specific operational problem while following the same approach to clarity, responsiveness and maintainability.'],
                'homepage_engineering_title' => ['label' => 'Engineering section title', 'default' => 'Modern on the surface. Practical underneath.'],
                'homepage_engineering_description' => ['label' => 'Engineering section description', 'default' => 'BusinessOS products are built around responsive interfaces, maintainable application architecture and performance that remains useful on real devices and imperfect networks.'],
                'homepage_resources_title' => ['label' => 'Resources section title', 'default' => 'Useful ideas for running better operations.'],
                'homepage_final_title' => ['label' => 'Final CTA title', 'default' => 'Find the right product for the part of your business you want to improve.'],
                'homepage_final_description' => ['label' => 'Final CTA description', 'default' => 'Explore FieldPulse, ERP and POS, or tell us about the workflow you need to improve and choose the product from the demo form.'],
            ],
            'about' => [
                'about_title' => ['label' => 'About title', 'default' => 'Software shaped around the way businesses actually operate.'],
                'about_lead' => ['label' => 'About lead', 'default' => 'BusinessOS is a growing software ecosystem focused on practical business workflows: sales, field operations, ERP, retail, automation and analytics.'],
                'about_body' => ['label' => 'About body', 'default' => 'BusinessOS applications are built around clear operational problems. Each product can stand on its own while sharing a consistent approach to usability, performance, security and long-term maintainability.'],
                'about_title_fa' => ['label' => 'About title — Dari', 'default' => 'نرم‌افزاری که مطابق شیوه واقعی فعالیت کسب‌وکارها ساخته شده است.'],
                'about_lead_fa' => ['label' => 'About lead — Dari', 'default' => 'BusinessOS یک اکوسیستم رو‌به‌رشد نرم‌افزاری برای روندهای عملی تجارت است.'],
                'about_body_fa' => ['label' => 'About body — Dari', 'default' => 'برنامه‌های BusinessOS بر اساس مشکلات روشن عملیاتی ساخته می‌شوند و یک رویکرد مشترک در استفاده‌پذیری، سرعت، امنیت و نگهداری دارند.'],
                'about_title_ps' => ['label' => 'About title — Pashto', 'default' => 'سافټویر چې د سوداګرۍ د واقعي فعالیت له مخې جوړ شوی.'],
                'about_lead_ps' => ['label' => 'About lead — Pashto', 'default' => 'BusinessOS د عملي سوداګریزو کاري بهیرونو لپاره د سافټویرونو وده کوونکی اکوسیستم دی.'],
                'about_body_ps' => ['label' => 'About body — Pashto', 'default' => 'د BusinessOS اپونه د روښانه عملیاتي ستونزو پر بنسټ جوړېږي او د کارونې، چټکتیا، امنیت او ساتنې ګډه تګلاره لري.'],
            ],
            'contact' => [
                'contact_email' => ['label' => 'Contact email', 'default' => '', 'max' => 190],
                'contact_phone' => ['label' => 'Contact phone', 'default' => '', 'max' => 80],
                'contact_address' => ['label' => 'Contact address', 'default' => 'Afghanistan', 'max' => 500],
            ],
            'seo' => [
                'seo_default_title' => ['label' => 'Default SEO title', 'default' => 'BusinessOS — Business Software for Field Sales, ERP & Retail', 'max' => 190],
                'seo_default_description' => ['label' => 'Default SEO description', 'default' => 'BusinessOS builds practical software for field sales, ERP, retail operations and business management.', 'max' => 255],
                'og_image' => ['label' => 'Default OG image URL/path', 'default' => '', 'max' => 2048],
            ],
        ];
    }
}
