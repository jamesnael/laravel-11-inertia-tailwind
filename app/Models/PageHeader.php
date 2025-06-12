<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class PageHeader extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

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

    protected $table = 'tb_page_header';

    protected $fillable = [
        'page',
        'title',
        'description',
        'banner_image',
    ];

    // protected $casts = [
    //     'description' => PurifyHtmlOnGet::class,
    // ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['page'],
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getBannerImageAttribute($value)
    {
        if($value) {
            return Storage::disk('public')->url($value);
        }
    }
}
