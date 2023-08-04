@extends('template.main')

@section('content')
    @isset($error)
        @dump($error)
    @endisset

    <h1 class="mb-3">Create New Post</h1>

    <div class="card mb-3">
        <div class="card-body">
            <form action="/new-post-handler" autocomplete="off" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Title</span>
                    <input type="text" class="form-control" name="title" id="judul" maxlength="255" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Author</span>
                    <input type="text" class="form-control" name="author" id="author" maxlength="255" list="authors" required>
                    <datalist id="authors">
                        @forelse ($authors as $author)
                            <option value="{{ $author->name }}">
                        @empty
                            
                        @endforelse
                    </datalist>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Category </span>
                    <input type="text" class="form-control" name="category" id="category" maxlength="255" list="categories" required>
                    <datalist id="categories">
                        @forelse ($categories as $category)
                            <option value="{{ $category->category }}">
                        @empty
                            
                        @endforelse
                    </datalist>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea name="content" class="form-control" id="content" rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
            </form>
        </div>
    </div>
@endsection