<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGuideRequest;
use App\Models\Guide;
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

    public function store(SaveGuideRequest $request): RedirectResponse
    {
        $data = $this->prepare($request->validated());

        $guide = Guide::create($data);

        return redirect()
            ->route('admin.guides.edit', $guide)
            ->with('status', 'Guide created.');
    }

    public function edit(Guide $guide): View
    {
        return view('admin.guides.form', compact('guide'));
    }

    public function update(SaveGuideRequest $request, Guide $guide): RedirectResponse
    {
        $guide->update($this->prepare($request->validated(), $guide));

        return back()->with('status', 'Guide updated.');
    }

    public function destroy(Guide $guide): RedirectResponse
    {
        $guide->delete();

        return redirect()
            ->route('admin.guides.index')
            ->with('status', 'Guide moved to trash.');
    }

    private function prepare(array $data, ?Guide $guide = null): array
    {
        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $guide);

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
