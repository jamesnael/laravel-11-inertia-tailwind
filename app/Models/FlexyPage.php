<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;

class FlexyPage extends Model
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

    protected $table = 'tb_flexy_page';

    protected $fillable = [
        'page',
        'title',
        'country_id',
        'is_agreement',
        'is_law',
        'is_news',
        'news_id',
        'event_id',
        'is_event',
        'non_gov_actor_id',
        'is_non_gov_actor',
        'publication_id',
        'is_publication',
        'project_id',
        'is_project',
        'measure_id',
        'is_measure',
        'zeroplastic_id',
        'is_zeroplastic',
        'epr_id',
        'is_epr',
        'plastic_id',
        'is_plastic',
        'product_id',
        'is_product',
        'is_assessment'
    ];

    protected $guarded = [];

    protected $casts = [
        'is_agreement' => 'boolean'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => ['title'],
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function paragraph()
    {
        return $this->hasMany(FlexyParagraph::class, 'flexy_id', 'id');
    }

    public function table()
    {
        return $this->hasMany(FlexyTable::class, 'flexy_id', 'id');
    }


    public function media()
    {
        return $this->hasMany(FlexyMedia::class, 'flexy_id', 'id');
    }

    public function quote()
    {
        return $this->hasMany(FlexyQuote::class, 'flexy_id', 'id');
    }

    public function faq()
    {
        return $this->hasMany(FlexyFaq::class, 'flexy_id', 'id');
    }

    public function reference()
    {
        return $this->hasMany(FlexyReference::class, 'flexy_id', 'id');
    }

    public function history()
    {
        return $this->hasMany(FlexyHistory::class, 'flexy_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
