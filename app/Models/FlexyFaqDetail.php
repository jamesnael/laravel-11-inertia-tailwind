<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class FlexyFaqDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_flexy_faq_detail';

    protected $fillable = [
        'flexy_id',
        'flexy_faq_id',
        'question',
        'answer',
    ];

    protected $guarded = [];

    protected $casts = [
    ];

}
