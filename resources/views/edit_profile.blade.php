@extends('layouts.app')

@section('content')

    <section class="listing" style="padding:8% 0;">

        @include('layouts._nav')


        <div class="container">
            <h2 class="fw-300 text-white">Edit Profile</h2>

            @if(session('success'))
                <div class="alert alert-success col-md-8 my-2 font-">
                    <strong>{{session('success')}}</strong>
                    <i class="fa fa-check fa-1x" aria-hidden="true"></i>
                </div> 
            @elseif(session('failure'))
                <div class="alert alert-danger col-md-8 my-2">
                    <strong>{{session('failure')}}</strong>
                    <i class="fa fa-times fa-1x" aria-hidden="true"></i>
                </div>
            @endif

            <form action="{{ route('update_profile') }}" method="POST" class="row py-4">
                @csrf

                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: #22A7F0">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" style="border:none">
                        @error('name')
                            <small class="text text-danger mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: #22A7F0">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}" style="border:none">
                        @error('email')
                            <small class="text text-danger mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: #22A7F0">Current Password</label>
                        <input type="password" name="current_password" class="form-control" style="border:none">
                        @error('current_password')
                            <small class="text text-danger mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: #22A7F0">New Password</label>
                        <input type="password" name="password" class="form-control" style="border:none">
                        @error('password')
                            <small class="text text-danger mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: #22A7F0">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" style="border:none">
                        @error('password_confirmation')
                            <small class="text text-danger mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8 mt-3">
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-primary" style="border:none">
                    </div>
                </div>
            </form>
        </div>

    </section>

    @include('layouts._footer')
@endsection