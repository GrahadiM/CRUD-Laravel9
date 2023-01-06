<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function guardName()
    {
      return 'api';
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d, M Y H:i');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->format('d, M Y H:i');
    }
}
