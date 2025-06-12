<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlexyLawPosition extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $table = 'tb_flexy_law_position';

    protected $fillable = [
        'country_id',
        'position',
    ];

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
