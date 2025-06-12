<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;

class Category extends Model
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

    protected $table = 'ms_category';

    protected $fillable = [
        'category',
        'tipe',
        'is_accordion',
        'is_detail_page',
    ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['category'],
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id', 'id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'category_id', 'id');
    }

    public function project()
    {
        return $this->hasMany(AboutOurProject::class, 'category_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany(AboutOurExpert::class, 'category_id', 'id');
    }

    public function actor()
    {
        return $this->hasMany(NonGovernmentAction::class, 'category_id', 'id');
    }

    public function publication()
    {
        return $this->hasMany(Publication::class, 'category_id', 'id');
    }
    
    public function practical_measure()
    {
        return $this->hasMany(PracticalMeasure::class, 'category_id', 'id');
    }

    public function plastic()
    {
        return $this->hasMany(Plastic::class, 'category_id', 'id');
    }

    public function multimedia()
    {
        return $this->hasMany(Multimedia::class, 'category_id', 'id');
    }
}
