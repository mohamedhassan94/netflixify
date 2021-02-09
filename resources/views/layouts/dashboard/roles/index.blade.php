@extends('layouts.dashboard.app')

@section('content')

<h2>Roles</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Roles</li>
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
                        @if ( Auth::user()->hasPermission('create_roles') )
                            <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
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
                        <th>Permissions</th>
                        <th>No of users</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td style="width:55%">
                                @foreach ($role->permissions as $permission)
                                    <span class="badge badge-primary">{{ $permission->name }}</span>
                                @endforeach
                        </td>
                        <td>{{ $role->users()->count() }}</td>
                        <td style="width:20%">
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" id="deleteForm{{ $role->id }}">
                                @csrf
                                @method('DELETE')

                                @if( Auth::user()->hasPermission('update_roles') )
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                @else
                                    <a disabled class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                @endif

                                @if ( Auth::user()->hasPermission('delete_roles') )
                                    <button type="submit" class="btn btn-danger btn-sm deleteRoleBtn" id="{{ $role->id }}">
                                    <i class="fa fa-trash"></i>Delete
                                    </button>
                                @else
                                    <button disabled class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i>Delete</button>
                                @endif

                            </form>
                        </td>
                    </tr>
                    @empty
                    <h3 style="font-weight: 400">No roles found</h3>
                    @endforelse
                </tbody>
            </table>

            {{ $roles->links() }}

        </div>
    </div>
</div>



@endsection

