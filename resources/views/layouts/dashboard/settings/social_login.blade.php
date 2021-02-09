@extends('layouts.dashboard.app');

@section('content')

<h2>Settings</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
</nav>

<div class="tile mb-4">

    <form action="{{ route('settings.store') }}" method="POST">
        @csrf

        @foreach ($social_sites as $social_site)
            <div class="form-group">
                <label class="text-capitalize">{{ $social_site }} Client Id</label>
                <input type="text" name="{{ $social_site }}_client_id"
                class="form-control mb-1" value="{{ setting($social_site.'_client_id') }}">
            </div>

            <div class="form-group">
                <label class="text-capitalize">{{ $social_site }} Client Secret</label>
                <input type="text" name="{{ $social_site }}_client_secret"
                class="form-control mb-1" value="{{ setting($social_site.'_client_secret') }}">
            </div>

            <div class="form-group">
                <label class="text-capitalize">{{ $social_site }} Redirect Url</label>
                <input type="text" name="{{ $social_site }}_redirect_url"
                class="form-control mb-1" value="{{ setting($social_site.'_redirect_url') }}">
            </div>
        @endforeach

        <div class="form-group mt-2">
            @if( Auth::user()->hasPermission('create_settings') )
                <button type="submit" class="btn btn-primary">Save</button>
            @else
                <button type="button" disabled class="btn btn-primary">Save</button>
            @endif
        </div>

    </form>

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
