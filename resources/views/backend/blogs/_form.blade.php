<div class="mb-3">
    <label id="title_label" for="title">Title</label>
    <input id="title" name="title" type="text" class="form-control" value="{{ $blog->title }}" />
    @error('title')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="photo">Blog Header Photo</label>
    <div class="custom-file">

        <div class="input-group mb-3 d-flex">
            <img id="output" height="100" width="200" class="img-fluid rounded" src="{{ asset('storage/' . $blog->photo) }}" />
            <input id="photo" name="photo" type="file" class="custom-file-input1 p-2" accept="image/*"
                aria-label="File Upload" onchange="loadFile(event)" value="{{ $blog->photo }}" />
            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <script>
            var loadFile = function(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('output');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            };
        </script>
    </div>
</div>

<div class="mb-3">
    <label id="video_label" for="video">Video Link</label>
    <input id="video" name="video" type="text" class="form-control" value="{{ $blog->video }}" />
    @error('video')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label id="content_label" for="content" class="required">Content</label>
    <textarea id="content" name="content" rows="5" class="form-control">{{ $blog->content }}</textarea>
    @error('content')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="select">
    <label id="status_label" for="status">Status</label>
    <div class="input-group mb-3">
        <select id="status" name="status" class="form-control form-select" aria-label="Status">
            <option></option>
            <option value="ACTIVE" @if ($blog->status == 'ACTIVE') selected @endif>ACTIVE</option>
            <option value="INACTIVE" @if ($blog->status == 'INACTIVE') selected @endif>INACTIVE</option>
        </select>
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>



<div class="block-header block-header-default">
    <h3 class="block-title">

    </h3>
    <div class="block-options">
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">{{$button}}</button>
        </div>
    </div>
</div>
