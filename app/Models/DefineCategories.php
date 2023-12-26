<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefineCategories extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function topics()
    {
        return $this->belongsTo(Topics::class);
    }



    // public function definecategories(){
    //     return $this->hasMany(DefinCategories::class)->orderBy('created_at', 'DESC');
    // }
}
