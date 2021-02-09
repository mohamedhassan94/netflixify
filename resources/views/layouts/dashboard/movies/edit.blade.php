@extends('layouts.dashboard.app');

@section('content')

<h2>movies</h2>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('movies.index') }}">Movies</a></li>
        <li class="breadcrumb-item active">Edit</li>

    </ul>

<div class="row">
    <div class="col-md-12">
        <div class="tile mb-4">
            <form action="{{ route('movies.update', ['movie' => $movie->id, 'type' => 'edit'] ) }}" method="POST" enctype="multipart/form-data">
                {{-- ['movie' => $movie->id, 'type' => 'edit'] --}}
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $movie->id }}" class="form-control my-2"/>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $movie->name) }}">
                    @error('name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label> <strong class="ml-2 text-info ">Max 500 Characters</strong>
                    <textarea name="description" rows="5" class="form-control">
                        {{ old('description', $movie->description) }}

                    </textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Movie Poster</label>
                    <input type="file" name="poster" class="form-control" >
                    @error('poster')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                    @if ($movie->poster != null )
                        <img src="{{ url('uploads/pictures/'. $movie->poster ) }}" class="mt-2 w-25">
                    @endif
                </div>

                <div class="form-group">
                    <label>Movie Background</label>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                    @if ($movie->image != null )
                        <img src="{{ url('uploads/pictures/'. $movie->image ) }}" class="mt-2 w-25" >
                    @endif
                </div>

                <div class="form-group">
                    <label>Categories</label><br>
                    <select name="categories[]" class="form-control select2" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @foreach ($movie->categories as $theCategory)
                                    {{ $theCategory->id == $category->id ? 'selected' : '' }}
                                @endforeach
                                >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <input type="text" name="year" class="form-control" value="{{ old('year', $movie->year,) }}">
                    @error('year')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Rating</label>
                    <input type="number" name="rating" class="form-control" value="{{ old('rating', $movie->rating,) }}">
                    @error('rating')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>Edit</button>

                </div>
            </form>

        </div>
    </div>
</div>

@endsection
