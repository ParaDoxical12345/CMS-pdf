<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'gender',
        'contact_no',
        'type',
        'email',
        'password',
        'status',


    ];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

        // public function hasRole($role)
        // {
        //     // Implement your logic here to check if the user has the given role.
        //     return $this->role === $role;
        // }
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
        'password' => 'hashed',
    ];
}
