<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Типы событий
     * $CONTACT_TYPE - событие контактов
     * $CHAT_TYPE - событие чата
     *
     * @var int
     */
    public static int $CONTACT_TYPE = 1;
    public static int $CHAT_TYPE = 2;

    /**
     * статус события
     * $NEW_STATUS - новое событие
     * $OLD_STATUS - просмоттренное событие
     *
     * @var int
     */
    public static int $NEW_STATUS = 1;
    public static int $VIEW_STATUS = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_user_id',
        'type',
        'status'
    ];
}
