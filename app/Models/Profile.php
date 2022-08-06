<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birthdate',
        'city',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * Шифруем пароль при сохранении
     *
     * @return Attribute
     */
    protected function birthdate(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $date = strtotime($value);
                return date('d.m.Y', $date);
            },
            set: function ($value) {
                $date = strtotime($value);
                return date('Y-m-d', $date);
            },
        );
    }
}
