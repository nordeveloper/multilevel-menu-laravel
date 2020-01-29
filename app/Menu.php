<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menus';
    
    protected $fillable = ['id','name','slug','parent_id','created_at','updated_at'];
    
    public function Main() 
    {
        return $this->belongsTo('App\Menu', 'parent_id', 'id');
    }
}
