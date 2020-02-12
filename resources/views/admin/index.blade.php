@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Manage menu
                    <span class="float-sm-right"> <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#addMenu">Add new menu</a></span>
                </div>

                <div class="card-body">
                    @if(count($menus) > 0)
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent menu</th>
                                <th>#</th>
                            </tr>
                        </thead>                        
                        <tbody>
                             @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->name }}</td>      
                                <td>{{ !empty($menu->parent_id) ? $menu->Main->name : 'Main menu..' }}</td>
                                <td>
                                    <span class="float-sm-right"> 
                                        <a href="{{ route('adminMenuDelete', ['id' => $menu->id]) }}" class="btn btn-danger">Delete</a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    {!! $menus->links() !!}
                    @else
                    <i>There is no menu in the database...</i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal add menu -->
<div class="modal fade" id="addMenu" tabindex="-1" role="dialog" aria-labelledby="addMenu" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMenu">Add new Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{ route('adminMenuAdd') }}" method="post">
            <div class="modal-body">        
                @csrf
                <div class="form-group">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" >                  
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                  <label for="parent_id">Parent menu</label>
                  <select type="text" class="form-control" id="parent_id" name="parent_id" >
                      <option value="">Main menu..</option>
                      @if(count($menus) > 0)
                        @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                      @endif
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('footer')
    @error('name')
    <script>
        $('#addMenu').modal('show');
        $('#name').addClass('is-invalid');
    </script>
    @enderror
@endsection