<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class FlexyParagraphDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_flexy_paragraph_detail';

    protected $fillable = [
        'flexy_id',
        'flexy_paragraph_id',
        'title',
        'description',
        'icon',
        'button_label',
        'button_url'
    ];

    protected $guarded = [];


    public function getIconAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }
}
