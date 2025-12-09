<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;

class Role extends Model
{
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

      // check if slug is changed
      if ($model->isDirty('slug') && $model->getOriginal('slug')) {
        SlugRedirect::create([
          'entity_type' => 'role',
          'id_content'  => $model->id,
          'old_slug'    => $model->getOriginal('slug'), // get old slug value
        ]);
      }
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
  protected $table = 'roles';

  protected $fillable = [
    'nama_jabatan',
    'tipe_user',
    'keterangan',
    'hak_akses',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'hak_akses' => 'array',
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
        'source'   => ['nama_jabatan'],
        'onUpdate' => true,
      ]
    ];
  }

  /**
   * Get the relations for the model.
   */
  public function user()
  {
    return $this->hasMany(User::class, 'id_jabatan', 'id');
  }
}
