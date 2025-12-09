<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'post_id', 'sender_name', 'sender_contact', 'message', 'reply_to_id'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }
}
