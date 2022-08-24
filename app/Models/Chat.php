<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'type',
    ];

    /**
     * Последнее сообщение
     *
     * @return HasOne
     */
    public function lastMessage(): HasOne
    {
        return $this
            ->hasOne(Message::class)
            ->where('user_id', '<>', Auth::id())
            ->latest();
    }
}
