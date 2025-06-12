<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;

class Tag extends Model
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

    protected $table = 'ms_tag';

    protected $fillable = [
        'tag',
    ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['tag'],
                'onUpdate' => true,
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function news()
    {
        return $this->hasMany(NewsTag::class, 'tag_id', 'id');
    }
}
