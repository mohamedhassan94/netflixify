@extends('layouts.app')

@section('content')

<section id="show">

    @include('layouts._nav')

    <div class="movie">

        <div class="movie__bg" style="background: linear-gradient(rgba(0,0,0, 0.6), rgba(0,0,0, 0.6)), url( {{ url('uploads/pictures/'.$movie->image) }} ) center/cover no-repeat;"></div>

        <div class="container">

            <div class="row">

                <div class="col-md-8">
                    <div id="player"></div>
                </div><!-- end of col -->

                <div class="col-md-4 text-white">
                    <h3 class="movie__name fw-300">{{ $movie->name }}</h3>

                    <div class="d-flex movie__rating my-1">
                        <div class="d-flex mr-2">
                            @for ($i = 0; $i < $movie->rating ; $i++)
                            <span class="fa fa-star text-primary mr-2"></span>
                            @endfor
                        </div>
                        <span class="align-self-center badge badge-warning text-bold" style="border-radius: 2px">{{ $movie->rating }}</span>
                    </div>

                    <p>Views: <span id="movie_views">{{ $movie->views }}</span></p>

                    <p class="movie__description my-3">{{ $movie->description }}</p>

                    @auth
                    <a class="btn btn-primary text-capitalize add-to-favorite-btn">
                        <span
                        class="fa fa-lg {{ in_array($movie->id, $favorite_movies) ? 'fa-heart' : 'fa-heart-o' }} align-self-center movie__fav-button movie-{{ $movie->id }}"
                        data-url="{{route('movies.toggle_favorite', $movie->id )}}"
                        data-movie_id={{ $movie->id }}
                        ></span> add to favorite
                    </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary text-capitalize my-3"><i class="fa fa-lg fa-heart-o"></i> add to favorites</a>
                    @endauth


                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of container -->

    </div><!-- end of movie -->

</section><!-- end of banner section-->

<div class="listing py-2">

    <div class="container">

        <div class="row my-4">
            <div class="col-12 d-flex justify-content-between">
                <h3 class="listing__title text-white fw-300">Related Movies</h3>
            </div>
        </div><!-- end of row -->

        <div class="movies owl-carousel owl-theme">

            @foreach ($related_movies as $related_movie)

            <div class="movie p-0">
                <img src="{{ url('uploads/pictures/'. $related_movie->poster) }}" class="img-fluid" alt="">

                <div class="movie__details text-white">

                    <div class="d-flex justify-content-between">
                        <p class="mb-0 movie__name">{{ $related_movie->name }}</p>
                        <p class="mb-0 movie__year align-self-center">{{ $related_movie->year }}</p>
                    </div>

                    <div class="d-flex movie__rating">
                        <div class="mr-2">
                            @for ($i = 0; $i < $related_movie->rating ; $i++)
                            <span class="fa fa-star text-primary mr-2"></span>
                            @endfor
                        </div>
                        <span class="align-self-center badge badge-warning text-bold" style="border-radius: 2px">{{ $movie->rating }}</span>
                    </div>

                    <div class="movie___views">
                        <p>Views: {{ $related_movie->views }}</p>
                    </div>

                    <div class="d-flex movie__cta">
                        <a href="{{ route('movies.watch', $related_movie->id) }}" class="btn btn-primary text-capitalize flex-fill mr-2"><i class="fa fa-play"></i> watch now</a>
                        @auth

                        <i data-url="{{ route('movies.toggle_favorite', $related_movie->id ) }}"
                            data-movie_id={{ $related_movie->id }}
                            class="fa fa-lg {{ in_array($related_movie->id, $favorite_movies) ? 'fa-heart' : 'fa-heart-o' }} align-self-center movie__fav-button movie-{{ $related_movie->id }}"></i>


                        @else
                        <a href="{{ route('login') }}" class="fa fa-lg fa-heart-o align-self-center movie__fav-button"></a>
                        @endauth
                    </div>

                </div><!-- end of movie details -->

            </div><!-- end of col -->

            @endforeach



        </div><!-- end of row -->

    </div><!-- end of container -->

</div><!-- end of listing section -->



@include('layouts._footer')

@endsection

@push('scripts')

<script>

    var file =  "[Auto]{{ url('uploads/movies/' . $movie->id . '/' . $movie->id . '.m3u8') }}," +
                "[360]{{ url('uploads/movies/' . $movie->id . '/' . $movie->id . '_0_100.m3u8') }}," +
                "[480]{{ url('uploads/movies/' . $movie->id . '/' . $movie->id . '_1_250.m3u8') }}," +
                "[720]{{ url('uploads/movies/' . $movie->id . '/' . $movie->id . '_2_500.m3u8') }},";

    var player = new Playerjs({
        "id": 'player',
        "file": file,
        "poster": " {{ url('uploads/pictures/'.$movie->poster) }} ",
        "default_quality": "Auto"
    });


    let viewsCounted = false;

    function PlayerjsEvents(event,id,data){
        if(event=="duration"){
            duration = data;
        }

        if(event == "time"){
            time = data;
        }

        let percent = (time * 100) / duration;

        if (percent > 10 && !viewsCounted){
            $.ajax({
                url: "{{ route('movies.increment_views', $movie->id) }}",
                method: "POST",
                success: function(){
                    let views = parseInt( $('#movie_views').html() );
                    $('#movie_views').html( views + 1 );
                }
            });

            viewsCounted = true;

        }
    }

</script>

@endpush
