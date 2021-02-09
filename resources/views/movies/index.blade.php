@extends('layouts.app')


@section('content')

<section class="listing text-white" style="min-height: 100vh; padding:8% 0;">

    @include('layouts._nav')

    <div class="container">

        <h2 class="fw-300">{{ request()->category_name }} Movies</h2>

        <div class="row">

            @forelse ($movies as $movie)

            <div class="col-md-3 movie my-3 ">
                <img src="{{ url('uploads/pictures/'.$movie->poster) }}" class="img-fluid">

                <div class="movie__details text-white px-2">

                    <div class="d-flex justify-content-between">
                        <p class="mb-0 movie__name">{{ $movie->name }}</p>
                        <p class="mb-0 movie__year align-self-center">{{ $movie->year }}</p>
                    </div>

                    <div class="d-flex movie__rating">
                        <div class="mr-2">
                            @for ($i = 0; $i < $movie->rating ; $i++)
                            <span class="fa fa-star text-primary mr-2"></span>
                            @endfor
                        </div>
                        <span class="badge badge-warning pt-1" style="border-radius: 2px">{{ $movie->rating }}</span>
                    </div>

                    <div class="movie___views">
                        <p>Views: {{ $movie->views }}</p>
                    </div>

                    <div class="d-flex movie__cta">
                        <a href="{{ route('movies.watch', $movie->id) }}" class="btn btn-primary text-capitalize flex-fill mr-2"><i class="fa fa-play"></i> watch now</a>
                        @auth
                        <i data-url="{{ route('movies.toggle_favorite', $movie->id ) }}"
                            data-movie_id={{ $movie->id }}
                            class="fa fa-lg {{ in_array($movie->id, $favorite_movies) ? 'fa-heart' : 'fa-heart-o' }} align-self-center movie__fav-button movie-{{ $movie->id }}"></i>
                        @else
                        <a href="{{ route('login') }}" class="fa fa-lg fa-heart-o align-self-center movie__fav-button"></a>
                        @endauth
                    </div>

                </div><!-- end of movie details -->

            </div><!-- end of col -->

            @empty

            <div class="col">
                <h5 class="fw-300">Sorry! this category does not have any movies yet.</h5>
            </div>

            @endforelse

        </div>

    </div>


</section>

@include('layouts._footer')

@endsection
