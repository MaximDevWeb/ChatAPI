<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use HasFactory;

    protected function avatar(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type === 'group') {
                return $this->avatar_link;
            } else {
                $participant = $this->participants()
                    ->where('user_id', '<>', Auth::id())
                    ->first();

                return $participant->user->avatar->link;
            }
        });
    }

    protected function name(): Attribute
    {
        return Attribute::get(function ($value) {
            if ($this->type === 'group') {
                return $value;
            } else {
                $participant = $this->participants()
                    ->where('user_id', '<>', Auth::id())
                    ->first();

                return $participant->user->profile->full_name ?: $participant->user->login;
            }
        });
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeMy($query)
    {
        $query->whereRelation('participants', 'user_id', Auth::id());
    }
}
