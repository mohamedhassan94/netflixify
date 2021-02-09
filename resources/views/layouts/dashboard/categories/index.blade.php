@extends('layouts.dashboard.app')

@section('content')

<h2>Categories</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
</nav>

<div class="tile mb-4">
    <div class="row">
        <div class="col-12">
            <form action="" method="Get">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="search" autofocus name="search" value="{{ request()->search }}"
                            class="form-control" placeholder="search">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            @if ( Auth::user()->hasPermission('create_categories') )
                                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add
                                </a>
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
                        <th>Movies Count</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->movies->count() }}</td>

                        <td>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" id="deleteForm{{ $category->id }}">
                                @csrf
                                @method('DELETE')

                                @if ( Auth::user()->hasPermission('update_categories') )
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>Edit
                                    </a>
                                @else
                                    <a disabled class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                @endif

                                @if ( Auth::user()->hasPermission('delete_categories') )
                                    <button type="submit" class="btn btn-danger btn-sm deleteCategoryBtn" id="{{ $category->id }}">
                                        <i class="fa fa-trash"></i>Delete
                                    </button>
                                @else
                                    <button disabled class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i>Delete</button>
                                @endif

                            </form>
                        </td>
                    </tr>
                    @empty
                    <h3 style="font-weight: 400">No categories found</h3>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}

        </div>
    </div>
</div>


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

@endsection

