<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'fullname',
        'username',
        'bio',
        'email',
        'password',
    ];
    
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // User has many Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    protected function profilePictureUrl(): Attribute {       
        return Attribute::make(
            get: fn() => $this->profile_picture ? asset( 'storage/' . $this->profile_picture ) : "https://ui-avatars.com/api/?name=" . $this->username
        );
    }
    
    protected function profileUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->profile_picture ? asset('storage/' . $this->profile_picture) : "https://ui-avatars.com/api/?name=" . $this->username
        );
    }
}