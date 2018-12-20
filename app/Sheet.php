<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    protected $fillable = ['name', 'user_id', 'content'];

    protected $casts = [
        'content' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getChannelNameAttribute()
    {
        return "sheet-{$this->id}";
    }

    // public function getFormattedContentAttribute()
    // {
        
    // }
}
