<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSeoPageRequest;
use App\Models\SeoPage;
use App\Services\IndexNowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SeoPageController extends Controller
{
    public function index(): View
    {
        return view('admin.seo-pages.index', ['pages' => SeoPage::query()->latest('updated_at')->paginate(25)]);
    }

    public function create(): View
    {
        return view('admin.seo-pages.form', ['page' => new SeoPage]);
    }

    public function store(SaveSeoPageRequest $request, IndexNowService $indexNow): RedirectResponse
    {
        $page = SeoPage::create($this->prepare($request->validated()));

        if ($page->status === 'published') {
            $indexNow->submit(route('seo-pages.show', $page));
        }

        return redirect()->route('admin.seo-pages.edit', $page)->with('status', 'Search landing page created.');
    }

    public function edit(SeoPage $seoPage): View
    {
        return view('admin.seo-pages.form', ['page' => $seoPage]);
    }

    public function update(SaveSeoPageRequest $request, SeoPage $seoPage, IndexNowService $indexNow): RedirectResponse
    {
        $seoPage->update($this->prepare($request->validated(), $seoPage));

        if ($seoPage->status === 'published') {
            $indexNow->submit(route('seo-pages.show', $seoPage));
        }

        return back()->with('status', 'Search landing page updated.');
    }

    public function destroy(SeoPage $seoPage, IndexNowService $indexNow): RedirectResponse
    {
        $url = route('seo-pages.show', $seoPage);
        $seoPage->delete();
        $indexNow->submit($url);

        return redirect()->route('admin.seo-pages.index')->with('status', 'Search landing page moved to trash.');
    }

    private function prepare(array $data, ?SeoPage $page = null): array
    {
        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $page);
        $data['target_keywords'] = $this->lines($data['target_keywords_text'] ?? '');
        $data['related_product_slugs'] = $this->lines($data['related_products_text'] ?? '');
        $data['faq'] = collect($this->lines($data['faq_text'] ?? ''))
            ->map(function (string $line): array {
                [$question, $answer] = array_pad(explode('|', $line, 2), 2, '');
                return ['question' => trim($question), 'answer' => trim($answer)];
            })
            ->filter(fn (array $item) => $item['question'] !== '' && $item['answer'] !== '')
            ->values()->all();

        unset($data['target_keywords_text'], $data['related_products_text'], $data['faq_text']);
        $data['published_at'] = $data['status'] === 'published' ? ($page?->published_at ?? now()) : null;

        return $data;
    }

    private function lines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value))->map(fn ($line) => trim((string) $line))->filter()->values()->all();
    }

    private function uniqueSlug(string $title, ?SeoPage $page = null): string
    {
        $base = Str::slug($title) ?: 'service';
        $slug = $base;
        $suffix = 2;

        while (SeoPage::withTrashed()->where('slug', $slug)->when($page, fn ($q) => $q->whereKeyNot($page->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
