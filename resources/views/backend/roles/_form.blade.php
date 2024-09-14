<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $role->name) }}" placeholder="Role Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="form-group col">
    <h4>Permissions:</h4>
    <div class="mb-4">
        @foreach($permissions as $permission)
            @if(in_array($permission->id, $rolePermissions))
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" value="{{$permission->id}}" id="{{$permission->name}}{{$permission->id}}" name="permissions[]" checked>
                  <label class="form-check-label" for="{{$permission->name}}{{$permission->id}}">{{$permission->name}}</label>
                </div>
            @else
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" value="{{$permission->id}}" id="{{$permission->name}}{{$permission->id}}" name="permissions[]">
                  <label class="form-check-label" for="{{$permission->name}}{{$permission->id}}">{{$permission->name}}</label>
                </div>
            @endif
        @endforeach
    </div>
</div>


<div class="block-header block-header-default">
    <h3 class="block-title">

    </h3>
    <div class="block-options">
        <button type="submit" class="btn btn-primary">{{$button}}</button>
    </div>
</div>

