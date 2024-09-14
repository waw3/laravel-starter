<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $permission->name) }}" placeholder="Permission Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>



<div class="block-header block-header-default">
    <h3 class="block-title">

    </h3>
    <div class="block-options">
        <button type="submit" class="btn btn-primary">{{$button}}</button>
    </div>
</div>
