<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCaseStudyRequest;
use App\Models\CaseStudy;
use App\Services\IndexNowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(): View
    {
        return view('admin.case-studies.index', ['caseStudies' => CaseStudy::query()->latest('updated_at')->paginate(25)]);
    }

    public function create(): View
    {
        return view('admin.case-studies.form', ['caseStudy' => new CaseStudy]);
    }

    public function store(SaveCaseStudyRequest $request, IndexNowService $indexNow): RedirectResponse
    {
        $caseStudy = CaseStudy::create($this->prepare($request->validated()));
        if ($caseStudy->status === 'published') {
            $indexNow->submit(route('case-studies.show', $caseStudy));
        }

        return redirect()->route('admin.case-studies.edit', $caseStudy)->with('status', 'Case study created.');
    }

    public function edit(CaseStudy $caseStudy): View
    {
        return view('admin.case-studies.form', compact('caseStudy'));
    }

    public function update(SaveCaseStudyRequest $request, CaseStudy $caseStudy, IndexNowService $indexNow): RedirectResponse
    {
        $caseStudy->update($this->prepare($request->validated(), $caseStudy));
        if ($caseStudy->status === 'published') {
            $indexNow->submit(route('case-studies.show', $caseStudy));
        }

        return back()->with('status', 'Case study updated.');
    }

    public function destroy(CaseStudy $caseStudy, IndexNowService $indexNow): RedirectResponse
    {
        $url = route('case-studies.show', $caseStudy);
        $caseStudy->delete();
        $indexNow->submit($url);

        return redirect()->route('admin.case-studies.index')->with('status', 'Case study moved to trash.');
    }

    private function prepare(array $data, ?CaseStudy $caseStudy = null): array
    {
        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['title'], $caseStudy);
        $data['published_at'] = $data['status'] === 'published' ? ($caseStudy?->published_at ?? now()) : null;
        return $data;
    }

    private function uniqueSlug(string $title, ?CaseStudy $caseStudy = null): string
    {
        $base = Str::slug($title) ?: 'case-study';
        $slug = $base;
        $suffix = 2;
        while (CaseStudy::withTrashed()->where('slug', $slug)->when($caseStudy, fn ($q) => $q->whereKeyNot($caseStudy->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }
        return $slug;
    }
}
