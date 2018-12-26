<?php

namespace App;

use App\Albums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{   use SoftDeletes;
    protected $table = 'images';
    protected $fillable = ['user_id','album_id','original_name','image_name','view_status','size','caption','size','ext','mime'];
    protected $dates = ['deleted_at'];

    public function album(){
    return $this->belongsTo(Albums::class,'album_id');
    }
}
