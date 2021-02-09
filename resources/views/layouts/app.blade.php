<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Netflixify</title>

    <!--font awesome-->
    <link rel="stylesheet" href="{{ asset('css/font-awesome5.11.2.min.css') }}">

    <!--bootstrap-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!--vendor css-->
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">

    <!--google font-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--main styles -->
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">

    <!--easy autocomplete-->
    <link rel="stylesheet" href="{{ asset('plugins/easyautocomplete/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/easyautocomplete/easy-autocomplete.themes.min.css') }}">


    <style>
        .dropdown-item {
            color: #22A7F0;
            padding-left: 1rem
        }
        .dropdown-item:hover {
            color: #fff;
            background-color: #22A7F0
        }
        .movie__fav-button{
            cursor: pointer;
            color: #fff;
        }
        .movie__fav-button:hover{
            text-decoration: none;
        }
        .add-to-favorite-btn:hover{
            color: #000 !important;
        }
        .add-to-favorite-btn:hover .movie__fav-button{
            color: #000 ;
        }
        .easy-autocomplete{
            width: 90%;
        }
        .easy-autocomplete input{
            color: #fff !important;
        }
        .eac-icon-left .eac-item img{
            max-height: 80px
        }
        .easy-autocomplete ul li{
            color: #000 !important;
        }
    </style>
</head>
<body>

@yield('content')


<!--jquery-->
<script src="{{ asset('js/jquery-3.4.0.min.js') }}"></script>

<!--bootstrap-->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>

<!--vendor js-->
<script src="{{ asset('js/vendor.min.js') }}"></script>

<!--main scripts-->
<script src="{{ asset('js/main.min.js') }}"></script>

<!--easy autocomplete-->
<script src="{{ asset('plugins/easyautocomplete/jquery.easy-autocomplete.min.js') }}"></script>

<!--player js-->
<script src="{{ asset('js/playerjs.js') }}"></script>

<!--custom movie js-->
<script src="{{ asset('js/custom/movie.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        $("#banner .movies").owlCarousel({
        loop: true,
        nav: false,
        items: 1,
        dots: false,
        });

        $(".listing .movies").owlCarousel({
        loop: true,
        nav: false,
        stagePadding: 50,
        responsive: {
            0: {
            items: 1
            },
            600: {
            items: 3
            },
            900: {
            items: 3
            },
            1000: {
            items: 4
            }
        },
        dots: false,
        margin: 15,
        loop: true,
        });

    });

    var options = {
        url: function(search){
            return "{{ route('movies.all') }}" + "?search=" + search;
        },
        getValue: 'name',
        template: {
            type: "iconLeft",
            fields: {
                iconSrc: "poster"
            }
        },
        list: {
            onChooseEvent: function() {
                let movie = $('#searchMovie').getSelectedItemData();
                let movie_id = movie.id
                let url = "{{ route('movies.watch', "")  }}" + "/" + movie_id;
                window.location.replace(url);
            }
        },

    };

    $('#searchMovie').easyAutocomplete(options);

</script>

@stack('scripts')

</body>
</html>
