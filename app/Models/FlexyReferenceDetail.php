<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class FlexyReferenceDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_flexy_reference_detail';

    protected $fillable = [
        'flexy_id',
        'flexy_reference_id',
        'title',
        'url',
        'accessed_date',
        'content'
    ];

    protected $guarded = [];

    // protected $casts = [
    //     'content' => PurifyHtmlOnGet::class,
    // ];

}
