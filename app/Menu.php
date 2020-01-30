<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    //
    protected $table = 'menus';
    
    protected $fillable = ['id','name','slug','parent_id','created_at','updated_at'];
    
    public function Main() 
    {
        return $this->belongsTo('App\Menu', 'parent_id', 'id');
    }
    
    public function Children() 
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }
    
    public static function showMenu()
    {        
        $data = Cache::get('menus_cache', null);         
        if (!is_null($data)) return $data;        
        $data = static::generateMenu();      
        Cache::put('menus_cache', $data, now()->addMinutes(60));        
        return $data;    
    }
    
    private static function generateMenu($parent_id=null)
    {        
        $result = '';
                
        if(is_null($parent_id))
        {
            $rows = self::whereNull('parent_id')->get();
        }else{
            $rows = self::where('parent_id',$parent_id)->get();
        }
                
        foreach($rows as $row)
        {                        
            if(count($row->children) == 0)
            {
                if(is_null($row->parent_id))
                {
                    $result .= '<li class="nav-item"><a href="#" class="nav-link">'.$row->name.'</a>';
                }else{
                    $result .= '<li><a href="#" class="dropdown-item">'.$row->name.'</a>';
                }                
            }else{                
                if(is_null($row->parent_id))
                {                    
                    $result .= '<li class="nav-item dropdown">
                                <a id="dropdownMenu'.$row->id.'" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                                '.$row->name.'</a>';
                }else{                    
                    $result .= '<li class="dropdown-submenu">
                                <a id="dropdownMenu'.$row->id.'" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">
                                '.$row->name.'</a>';
                } 
                $result .= '<ul aria-labelledby="dropdownMenu'.$row->id.'" class="dropdown-menu border-0 shadow">'.static::generateMenu($row->id).'</ul>';
            }            
            $result .= '</li>';            
        }        
        return $result;
    }
}
