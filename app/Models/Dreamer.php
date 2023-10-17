<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Dreamer extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'name',
        'birthdate',
        'user_id',
        'group_id',
    ];


    public function user() {

        return $this->belongsTo(User::class);
    }

    protected static function boot() {
        parent::boot();

        static::creating(function($dreamer) {
            $dreamer->avatar = self::generateUniqueAvatar();
        });
    }

    public static function generateUniqueAvatar() {
        $uniqueAvatar = null;
        do {
            $uniqueAvatar = mt_rand(100, 999);
        } while (self::where('avatar', $uniqueAvatar)->exists());

        return $uniqueAvatar;
    }
}
