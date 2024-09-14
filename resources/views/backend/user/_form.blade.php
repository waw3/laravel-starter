

<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="first_name" class="form-label ">First Name</label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name='first_name' value="{{ old('first_name', $user->first_name) }}" placeholder="First Name">
        @error('first_name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="last_name" class="form-label ">last Name</label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name='last_name' value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name">
        @error('last_name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="email" class="form-label ">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name='email' value="{{ old('email', $user->email) }}" placeholder="User Email">
        @error('email')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="row">
    <div class="form-group col">
        <h4>Roles:</h4>
        <div class="mb-4">
            @foreach($roles as $role)
                @if(in_array($role->id, $userRoles))
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" value="{{$role->id}}" id="{{$role->name}}{{$role->id}}" name="roles[]" checked>
                      <label class="form-check-label" for="{{$role->name}}{{$role->id}}">{{$role->name}}</label>
                    </div>
                @else
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" value="{{$role->id}}" id="{{$role->name}}{{$role->id}}" name="roles[]">
                      <label class="form-check-label" for="{{$role->name}}{{$role->id}}">{{$role->name}}</label>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="form-group col">
        <h4>Permissions:</h4>
        <div class="mb-4">
            @foreach($permissions as $permission)
                @if(in_array($permission->id, $userPermissions))
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
</div>


<div class="block-header block-header-default">
    <h3 class="block-title">

    </h3>
    <div class="block-options">
        <button type="submit" class="btn btn-primary">{{$button}}</button>
    </div>
</div>

