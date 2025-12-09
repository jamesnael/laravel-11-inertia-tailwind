<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
  use HasApiTokens, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;
  use HasFactory, SoftDeletes, Sluggable, Filterable;

  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function booted()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->created_by = \Auth::user()->nama_lengkap ?? 'System';
      $model->updated_by = \Auth::user()->nama_lengkap ?? 'System';
    });
    static::updating(function ($model) {
      $model->updated_by = \Auth::user()->nama_lengkap ?? 'System';
    });
    static::deleted(function ($model) {
      $model->deleted_by = \Auth::user()->nama_lengkap ?? 'System';
      $model->save();
    });
  }

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'users';

  protected $fillable = [
    'nama_lengkap',
    'tanggal_lahir',
    'nomor_hp',
    'username',
    'email',
    'password',
    'alamat_lengkap',
    'remember_token',
    'profile_photo_path',
    'id_jabatan',
    'status',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'status' => 'boolean',
    'tanggal_lahir' => 'date:Y-m-d',
    'approval_status' => 'string',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = [
    'profile_photo_url',
  ];

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable(): array
  {
    return [
      'slug' => [
        'source'   => ['nama_lengkap'],
        'onUpdate' => true,
      ]
    ];
  }

  /**
   * Get the model's ektp path.
   *
   * @param  string  $value
   * @return string
   */
  public function getEktpPathAttribute($value)
  {
    return Storage::disk('public')->url($value);
  }

  /**
   * Get the relations for the model.
   */
  public function role()
  {
    return $this->belongsTo(Role::class, 'id_jabatan', 'id');
  }
}
