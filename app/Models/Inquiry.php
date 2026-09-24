<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'source_url',
        'ip_hash',
        'user_agent',
    ];
}
