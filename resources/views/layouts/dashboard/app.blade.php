<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
        <title>Netflixify</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

                {{-- notyCSSfile --}}
        <link rel="stylesheet" type="text/css" href=" {{ asset('dashboard/plugins/noty/noty.css') }} ">

        {{-- bootstrap sweetalert CSSfile --}}
        <link rel="stylesheet" type="text/css" href=" {{ asset('dashboard/plugins/bootstrap_sweetalert/sweetalert.css') }} ">

                {{-- weincludethisfiletousethenestthemeofnotifications --}}
        <link rel="stylesheet" type="text/css" href=" {{ asset('dashboard/plugins/noty/nest.css') }} ">

        <link rel="stylesheet" type="text/css" href=" {{ asset('dashboard/plugins/noty/metroui.css') }} ">

                {{-- notyJSfile --}}
        <script src="{{ asset('dashboard/plugins/noty/noty.js') }}"></script>

                {{-- bootstrap sweetalert JSfile --}}
        <script src="{{ asset('dashboard/plugins/bootstrap_sweetalert/sweetalert.js') }}"></script>

                {{-- select2CSSfile --}}

        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/select2/select2.min.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/custom/movie.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/main.css') }}">

        <style>
            label {
                font-weight: bold
            }
        </style>

    </head>
    <body class="app sidebar-mini" style="background-color: #E5E5E5">

        @include('layouts.dashboard._header')

        @include('layouts.dashboard._aside')
        <main class="app-content">

        @yield('content')

        </main>
        <!-- Essential javascripts for application to work-->

        <script src="{{ asset('dashboard/js/jquery-3.3.1.min.js') }}"></script>

        <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>

        <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>

                        <!-- select2 JS file -->

        <script src="{{ asset('dashboard/plugins/select2/select2.min.js') }}"></script>

        <script src="{{ asset('dashboard/js/custom/movie.js') }}"></script>

        <script src="{{ asset('dashboard/js/main.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready( function(){

        // categories delete confirm box

        $('.deleteCategoryBtn').click( function(e){
            e.preventDefault();

            var category_id = $(this).attr('id');

            swal({
                title: "Do you want to delete this category?",
                text: "Your will not be able to restore this category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
                },
                function(){
                    swal("Category Deleted!", "Your category has been deleted.", "success");
                    $('#deleteForm'+category_id).submit();
                });

            });


        // roles delete confirm box

        $('.deleteRoleBtn').click( function(e){
            e.preventDefault();

            var role_id = $(this).attr('id');
            swal({
                title: "Do you want to delete this role?",
                text: "Your will not be able to restore this role!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
                },
                function(){
                    swal("Role Deleted!", "Your role has been deleted.", "success");
                    $('#deleteForm'+role_id).submit();
                });

            });

            // users delete confirm box

        $('.deleteuserBtn').click( function(e){
            e.preventDefault();

            var user_id = $(this).attr('id');

            swal({
                title: "Do you want to delete this user?",
                text: "You will not be able to restore this user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
                },
                function(){
                    swal("User Deleted!", "Your user has been deleted.", "success");
                    $('#deleteForm'+user_id).submit();
                });

            });

            $('.select2').select2();



            $('.deleteMovieBtn').click( function(e){
                e.preventDefault();

                var movie_id = $(this).attr('id');

                swal({
                    title: "Do you want to delete this movie?",
                    text: "You will not be able to restore this movie!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                    },
                    function(){
                        swal("Movie Deleted!", "Your movie has been deleted.", "success");
                        $('#deleteForm'+movie_id).submit();
                    });

                });

                $('.select2').select2();






        } )









</script>
    </body>
</html>
