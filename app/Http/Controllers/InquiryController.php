<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company' => $data['company'] ?? null,
            'phone' => $data['phone'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'app_slug' => $data['app_slug'] ?? null,
            'team_size' => $data['team_size'] ?? null,
            'message' => $data['message'],
            'source_url' => $request->headers->get('referer'),
            'ip_hash' => $request->ip() ? Hash::make($request->ip()) : null,
            'user_agent' => str($request->userAgent())->limit(500)->toString(),
        ]);

        return back()->with('inquiry_success', 'Thanks — your request has been received. We will follow up using the contact details you provided.');
    }
}
