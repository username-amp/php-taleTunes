<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'birthday',
        'gender',
        'email',
        'password',
        'is_favorite',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthday' => 'date',
            'password' => 'hashed',
        ];
    }

    public function ownedRooms()
    {
        return $this->hasMany(Room::class, 'owner_id');
    }

    public function joinedRooms()
    {
        return $this->belongsToMany(Room::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function audiobooks()
    {
        return $this->hasMany(\App\Models\Audiobook::class);
    }

    public function favoriteAudiobooks()
    {
        return $this->belongsToMany(Audiobook::class, 'audiobook_user')
            ->withTimestamps();
    }
}
