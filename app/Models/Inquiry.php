<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'inquiry_type',
        'app_slug',
        'team_size',
        'message',
        'status',
        'follow_up_at',
        'resolved_at',
        'source_url',
        'ip_hash',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function notes(): HasMany
    {
        return $this->hasMany(InquiryNote::class)->latest();
    }
}
