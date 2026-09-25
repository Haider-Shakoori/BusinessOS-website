<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $ip = $request->ip();
        $appKey = (string) config('app.key');

        Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company' => $data['company'] ?? null,
            'phone' => $data['phone'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'app_slug' => $data['app_slug'] ?? null,
            'team_size' => $data['team_size'] ?? null,
            'message' => $data['message'],
            'status' => 'new',
            'source_url' => $request->headers->get('referer'),
            'ip_hash' => $ip && $appKey !== '' ? hash_hmac('sha256', $ip, $appKey) : null,
            'user_agent' => str($request->userAgent())->limit(500)->toString(),
        ]);

        return back()->with('inquiry_success', __('marketing.inquiry_received'));
    }
}
