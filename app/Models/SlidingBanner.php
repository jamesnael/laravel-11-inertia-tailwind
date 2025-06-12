<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SlidingBanner extends Model
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
    protected $table = 'tb_sliding_banner';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['title'],
                'onUpdate' => true,
            ]
        ];
    }

    public function getDesktopBannerAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }

    public function getMobileBannerAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }
}
