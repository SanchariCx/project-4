<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    protected $table = 'albums';
    protected $fillable = ['name','description','user_id'];
  
    public function images(){
       return $this->hasMany(Images::class,'album_id');
    }
}
