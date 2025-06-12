<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class FlexyParagraph extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_flexy_paragraph';

    protected $fillable = [
        'flexy_id',
        'position',
        'title',
        'content',
        'title_size'
    ];

    protected $guarded = [];

    // protected $casts = [
    //     'content' => PurifyHtmlOnGet::class,
    // ];

    public function detail()
    {
        return $this->hasMany(FlexyParagraphDetail::class, 'flexy_paragraph_id', 'id');
    }

}
