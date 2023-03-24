<?php

namespace App\Models;

use App\Enums\Role;
use App\Notifications\ResetPasswordQueued;
use App\Notifications\VerifyEmailQueued;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'created_by', 'id');
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class, 'created_by', 'id');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(Allocation::class, 'created_by', 'id');
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailQueued);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordQueued($token));
    }

    public function is_admin(): bool
    {
        return $this->role === Role::Admin->value;
    }

    public function is_staff(): bool
    {
        return $this->role === Role::Staff->value;
    }

    public function is_provider(): bool
    {
        return $this->role === Role::Provider->value;
    }

    public function canAccessFilament(): bool
    {
        return $this->is_admin() || $this->is_staff();
    }
}
