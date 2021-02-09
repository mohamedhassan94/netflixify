@extends('layouts.dashboard.app')

@section('content')

<h2>movies</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Movies</li>
    </ol>
</nav>

<div class="tile mb-4">
    <div class="row">
        <div class="col-12">
            <form action="" method="Get">
                <script>
                    @if(Session('message'))
                        new Noty({
                            text: "{{ session('message') }}",
                            layout: 'topRight',
                            timeout: 2000,
                            type: 'success',
                            theme: 'nest',
                            killer: true,
                        }).show();
                    @endif
                </script>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="search" autofocus name="search" value="{{ request()->search }}"
                            class="form-control" placeholder="search">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        @if ( Auth::user()->hasPermission('create_movies') )
                            <a href="{{ route('movies.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                        @else
                            <a disabled class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Categories</th>
                        <th>Year</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($movies as $index => $movie)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $movie->name }}</td>
                        <td style="width:25%">{{ Str::limit( $movie->description, 50 ) }}</td>
                        <td style="width:23%">
                            @foreach ($movie->categories as $categorie)
                                <span class="badge badge-primary">{{ $categorie->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $movie->year }}</td>
                        <td>{{ $movie->rating }}</td>

                        <td>
                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" id="deleteForm{{ $movie->id }}">
                                @csrf
                                @method('DELETE')

                                @if( Auth::user()->hasPermission('update_movies') )
                                    <a href="{{ route('movies.edit', $movie->id) }}"
                                        class="btn {{ $movie->description == null ? 'btn-success' : 'btn-warning' }} btn-sm">
                                        <i class="fa fa-edit"></i>
                                        {{ $movie->description == null ? 'Publish' : 'Edit' }}
                                    </a>
                                @else
                                    <a disabled class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>
                                        {{ $movie->description == null ? 'Publish' : 'Edit' }}
                                    </a>
                                @endif

                                @if ( Auth::user()->hasPermission('delete_movies') )
                                    <button type="submit" class="btn btn-danger btn-sm deleteMovieBtn" id="{{ $movie->id }}">
                                    <i class="fa fa-trash"></i>Delete
                                    </button>
                                @else
                                    <button disabled class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i>Delete</button>
                                @endif

                            </form>
                        </td>
                    </tr>
                    @empty
                    <h3 style="font-weight: 400">No movies found</h3>
                    @endforelse
                </tbody>
            </table>

            {{ $movies->links() }}

        </div>
    </div>
</div>



@endsection

