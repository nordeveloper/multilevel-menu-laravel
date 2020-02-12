<?php

namespace App\Repositories\Admin\Index;

use App\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Admin\Index\AdminIndexRepositoriesInterface;

class AdminIndexRepositories implements AdminIndexRepositoriesInterface 
{

    public function getAllPaginate($paginate) 
    {
        return Menu::select('id', 'name', 'parent_id')->paginate($paginate);
    }

    public function create($request) 
    {
        $this->validateForm($request);

        $menu = New Menu();
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->slug = Str::slug($request->name);
        $menu->save();

        $this->cacheClear('menus_cache');
    }
    
    public function update($request, $id) 
    {
        // TODO
    }

    public function delete($id) 
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        $this->cacheClear('menus_cache');
    }
    
    private function cacheClear($cacheName)
    {
        Cache::forget($cacheName);
    }

    private function validateForm($request)
    {
        return $request->validate(['name' => 'required|unique:menus|max:191']);
    }
}
