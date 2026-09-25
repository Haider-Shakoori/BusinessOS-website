<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $product = (string) $request->query('product', '');
        $type = (string) $request->query('type', '');

        $inquiries = Inquiry::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('company', 'like', '%'.$search.'%')
                        ->orWhere('message', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($status, ['new', 'in_progress', 'resolved', 'archived'], true), fn ($q) => $q->where('status', $status))
            ->when($product !== '', fn ($q) => $q->where('app_slug', $product))
            ->when(in_array($type, ['contact', 'demo', 'sales'], true), fn ($q) => $q->where('inquiry_type', $type))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'search' => $search,
            'status' => $status,
            'product' => $product,
            'type' => $type,
            'products' => Product::query()->orderBy('name')->get(['name', 'slug']),
            'counts' => Inquiry::query()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
        ]);
    }

    public function show(Inquiry $inquiry): View
    {
        $inquiry->load(['notes.user']);

        return view('admin.inquiries.show', [
            'inquiry' => $inquiry,
            'products' => Product::query()->orderBy('name')->get(['name', 'slug']),
        ]);
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_progress,resolved,archived'],
            'follow_up_at' => ['nullable', 'date'],
        ]);

        $data['resolved_at'] = $data['status'] === 'resolved'
            ? ($inquiry->resolved_at ?? now())
            : null;

        $inquiry->update($data);

        return back()->with('status', 'Inquiry updated.');
    }

    public function storeNote(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $data = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $inquiry->notes()->create([
            'user_id' => $request->user()?->getKey(),
            'note' => $data['note'],
        ]);

        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'in_progress']);
        }

        return back()->with('status', 'Internal note added.');
    }
}
