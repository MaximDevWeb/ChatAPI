<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    /**
     * Варианты типов авататров
     * $DEFAULT_TYPE - один из предложенных вариантов
     * $CUSTOM_TYPE - свой автар
     *
     * @var int
     */
    public static int $DEFAULT_TYPE = 1;
    public static int $CUSTOM_TYPE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'path',
        'link',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];
}
