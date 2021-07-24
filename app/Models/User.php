<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'username',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'date_of_birth',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'uuid',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'date_of_birth' => 'datetime:Y-m-d',
    ];

    /**
     * the format date be used when actually storing a model's dates.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * the default serialization format for all of your model's dates.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return ($date) ? (new Carbon($date))->isoFormat('YYYY-MM-DD') : null;
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // event before create data
        static::creating(function (User $user) {
            $user->uuid = (string) Str::uuid();
            if (auth()->user()) {
                $user->created_by = auth()->user()->id;
                $user->updated_by = auth()->user()->id;
            }
        });

        // event after create data
        static::created(function (User $user) {
            if (empty($user->role)) {
                $user->role()->associate(2);
                $user->save();
            }
        });

        // event before update data
        static::updating(function (User $user) {
            if (auth()->user()) {
                $user->updated_by = auth()->user()->id;
            }
        });

        // event after delete data
        static::deleted(function (User $user) {
            if (auth()->user()) {
                $user->deleted_by = auth()->user()->id;
                $user->save();
            }
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
