<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','title', 'description', 'type', 'location', 'image', 'status', 'approved_by'
    ];

    protected $casts = [
        'type' => 'string',
        'status' => 'string',
        'approved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // post belongs to user
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
