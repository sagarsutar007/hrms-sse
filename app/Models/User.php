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

    // Specify the primary key column name
    protected $primaryKey = 'Employee_id';

    // If Employee_id is auto-incrementing, keep this as true
    public $incrementing = true;

    // Specify the key type
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'f_name',
        'm_name',
        'l_name',
        'email',
        'password',
        'mobile_number',
        'role', // Add role to fillable attributes
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
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is a super admin
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 1;
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 2;
    }

    /**
     * Check if the user is an HR
     *
     * @return bool
     */
    public function isHR(): bool
    {
        return $this->role === 3;
    }

    public function adminlte_image()
    {
        return 'https://avatar.iran.liara.run/username?username=User';  // or any default image path
    }


}
