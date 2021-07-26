<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'detail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
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
    protected function serializeDate(\DateTimeInterface $date): ?string
    {
        return ($date) ? (new Carbon($date))->isoFormat('YYYY-MM-DD') : null;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // event before create data
        static::creating(function (Role $data) {
            $data->uuid = (string) Str::uuid();
            if (auth()->user()) {
                $data->created_by = auth()->user()->id;
                $data->updated_by = auth()->user()->id;
            }
        });

        // event before update data
        static::updating(function (Role $data) {
            if (auth()->user()) {
                $data->updated_by = auth()->user()->id;
            }
        });

        // event after delete data
        static::deleted(function (Role $data) {
            if (auth()->user()) {
                $data->deleted_by = auth()->user()->id;
                $data->save();
            }
        });
    }

   /**
     * relation to table user on created_by
     *
     * @return object
     */
    public function createdBy(): object
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * relation to table user on updated_by
     *
     * @return object
     */
    public function updatedBy(): object
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * relation to table user on deleted_by
     *
     * @return object
     */
    public function deletedBy(): object
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * relation to table user on role_id
     *
     * @return object
     */
    public function users(): object
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * relation many to many to table permissions on permission_id
     *
     * @return object
     */
    public function permissions(): object
    {
        return $this->belongsToMany(Permission::class);
    }
}
