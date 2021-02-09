@extends('layouts.dashboard.app');

@section('content')

<h2>Users</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Add</li>

    </ol>
</nav>

<div class="tile mb-4">

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control mb-1" value="{{ old('name') }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control mb-1" value="{{ old('email') }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control mb-1" value="{{ old('password') }}">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control mb-1" value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Select role</label>
            <select name="role_id" class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" >{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('roles.create') }}" target="_blank">Create new role</a>

        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>Add</button>
        </div>
    </form>

</div>

@endsection
