<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class FlexyFaq extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::boot();

    }

    protected $table = 'tb_flexy_faq';

    protected $fillable = [
        'flexy_id',
        'position',
    ];

    protected $guarded = [];

    protected $casts = [
    ];

    public function detail()
    {
        return $this->hasMany(FlexyFaqDetail::class, 'flexy_faq_id', 'id');
    }

}
