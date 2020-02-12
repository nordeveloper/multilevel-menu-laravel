<?php

namespace App\Repositories\Admin\Index;

interface AdminIndexRepositoriesInterface 
{
    public function getAllPaginate($paginate);
    
    public function create($request);
    
    public function delete($id);
    
    public function update($request, $id);
}