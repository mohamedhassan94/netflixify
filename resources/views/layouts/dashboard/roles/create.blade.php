@extends('layouts.dashboard.app');

@section('content')

<h2>roles</h2>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Add</li>

    </ul>

<div class="row">
    <div class="col-md-12">
        <div class="tile mb-4">

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" autofocus name="name" class="form-control mb-1" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Display name</label>
                    <input type="text" name="display_name" class="form-control mb-1" value="{{ old('display_name') }}">
                    @error('display_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="form-control mb-1" >
                        {{ old('description') }}
                    </textarea>

                </div>


                <!-- add permissions -->

                <h4>Permissions</h4>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 20%">Section</th>
                            <th style="width: 70%">Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($models as $index => $model)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-capitalize">{{ $model }}</td>
                        <td>
                            @if ($model == 'settings')
                                @php
                                    $permissions = ['read', 'create'];
                                @endphp
                            @endif
                            <select name="permissions[]" class="form-control select2" multiple>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission.'_'.$model }}">
                                        {{ $permission }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @error('permissions')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>Add</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
