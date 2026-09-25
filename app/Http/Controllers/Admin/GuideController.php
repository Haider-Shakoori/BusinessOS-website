<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGuideRequest;
use App\Models\Guide;
use App\Services\IndexNowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        return view('admin.guides.index', [
            'guides' => Guide::query()->latest('updated_at')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.guides.form', ['guide' => new Guide]);
    }

    public function store(SaveGuideRequest $request, IndexNowService $indexNow): RedirectResponse
    {
        $data = $this->prepare($request->validated());

        $guide = Guide::create($data);

        if ($guide->status === 'published') {
            $indexNow->submit(route('resources.show', $guide));
        }

        return redirect()
            ->route('admin.guides.edit', $guide)
            ->with('status', 'Guide created.');
    }

    public function edit(Guide $guide): View
    {
        return view('admin.guides.form', compact('guide'));
    }

    public function update(SaveGuideRequest $request, Guide $guide, IndexNowService $indexNow): RedirectResponse
    {
        $guide->update($this->prepare($request->validated(), $guide));

        if ($guide->status === 'published') {
            $indexNow->submit(route('resources.show', $guide));
        }

        return back()->with('status', 'Guide updated.');
    }

    public function destroy(Guide $guide, IndexNowService $indexNow): RedirectResponse
    {
        $url = route('resources.show', $guide);
        $guide->delete();
        $indexNow->submit($url);

        return redirect()
            ->route('admin.guides.index')
            ->with('status', 'Guide moved to trash.');
    }

    private function prepare(array $data, ?Guide $guide = null): array
    {
        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $guide);
        $data['author_name'] = trim((string) ($data['author_name'] ?? '')) ?: 'BusinessOS Editorial Team';
        $data['author_role'] = trim((string) ($data['author_role'] ?? '')) ?: 'Business software & operations';
        $data['author_bio'] = trim((string) ($data['author_bio'] ?? '')) ?: 'BusinessOS publishes practical guidance based on software engineering, operational workflows and implementation experience.';

        if ($data['status'] === 'published') {
            $data['published_at'] = $guide?->published_at ?? now();
        } else {
            $data['published_at'] = null;
        }

        return $data;
    }

    private function uniqueSlug(string $title, ?Guide $guide = null): string
    {
        $base = Str::slug($title) ?: 'guide';
        $slug = $base;
        $suffix = 2;

        while (
            Guide::withTrashed()
                ->where('slug', $slug)
                ->when($guide, fn ($query) => $query->where($guide->getKeyName(), '!=', $guide->getKey()))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
