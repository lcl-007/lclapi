<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','goods_id','num'];

    public function goods()
    {
        return $this->belongsTo(Good::class,'goods_id','id');
    }
}
