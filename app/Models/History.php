<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class History extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Filterable;

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

    protected $table = 'tb_history';

    protected $fillable = [
        'year',
        'description',
        'image',
        'image_source',
    ];

    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['year'],
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }
}
