<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_SCIENTIST = 'scientist';
    public const ROLE_UNIVERSITY = 'university';
    public const ROLE_NII = 'nii';
    public const ROLE_INVESTOR = 'investor';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'cover_image',
        'role',
        'phone',
        'organization_id',
        'organization_name',
        'position',
        'verification_status',
        'verification_type',
        'verified_at',
        'bio',
        'expertise',
        'works',
        'business_profile',
        'profile_theme',
        'publications',
        'awards',
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
            'verified_at' => 'datetime',
            'expertise' => 'array',
            'works' => 'array',
            'business_profile' => 'array',
            'profile_theme' => 'array',
            'publications' => 'array',
            'awards' => 'array',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function technologies()
    {
        return $this->hasMany(Technology::class, 'owner_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class, 'investor_id');
    }

    public function exchangeRequests()
    {
        return $this->hasMany(ExchangeRequest::class, 'company_id');
    }
}
