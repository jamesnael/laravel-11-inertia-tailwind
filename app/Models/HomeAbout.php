<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class HomeAbout extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_home_about';

    protected $fillable = [
        'left_text',
        'left_button_label',
        'left_button_link',
        'right_text',
        'right_button_label',
        'right_button_link',
    ];

    protected $guarded = [];

    protected $casts = [
    ];

}
