<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'chat_id',
        'alert',
        'last_visit',
    ];

    /**
     * Отношение к чату
     *
     * @return HasOne
     */
    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class);
    }
}
