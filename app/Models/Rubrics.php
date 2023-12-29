<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrics extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function topics()
    {
        return $this->belongsTo(Topics::class);
    }
}
