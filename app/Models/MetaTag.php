<?php
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use EloquentFilter\Filterable;

class MetaTag extends Model
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

    protected $table = 'tb_meta_tag';

    protected $fillable = [
        'page_name',
        'title',
        'description',
        'route_slug',
        'controller_name'
    ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['page_name'],
            ]
        ];
    }
}
