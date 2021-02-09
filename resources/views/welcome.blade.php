@extends('layouts.app')


@section('content')
    <section id="banner" style="min-height: 100vh">

        @include('layouts._nav')

        <div class="movies owl-carousel owl-theme">
                
            @foreach ($latest_movies as $latest_movie)

            <div class="movie text-white d-flex justify-content-center align-items-center">

                <div class="movie__bg" style="background: linear-gradient(rgba(0,0,0, 0.6), rgba(0,0,0, 0.6)), url( {{ url('uploads/pictures/'.$latest_movie->image) }} ) center/cover no-repeat;"></div>

                <div class="container">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="d-flex justify-content-between">
                                <h1 class="movie__name fw-300">{{ $latest_movie->name }}</h1>
                                <span class="movie__year align-self-center">{{ $latest_movie->year }}</span>
                            </div>

                            <div class="d-flex movie__rating my-1">
                                <div class="d-flex">
                                    @for ($i = 0; $i < $latest_movie->rating ; $i++)
                                    <span class="fa fa-star text-primary mr-2"></span>
                                    @endfor
                                </div>
                                <span class="align-self-center badge badge-warning text-bold" style="border-radius: 2px">
                                    {{ $latest_movie->rating }}
                                </span>
                            </div>

                            <p class="movie__description my-2">{{ $latest_movie->description }}</p>

                            <div class="movie__cta my-4">
                                <a href="{{ route('movies.watch', $latest_movie->id ) }}" class="btn btn-primary text-capitalize mr-0 mr-md-2"><span class="fa fa-play"></span> watch now</a>

                                @auth
                                <a class="btn btn-outline-light text-capitalize add-to-favorite-btn"

                                >
                                    <span
                                    class="fa fa-lg {{ in_array($latest_movie->id, $favorite_movies) ? 'fa-heart' : 'fa-heart-o' }} align-self-center movie__fav-button movie-{{ $latest_movie->id }}"
                                    data-url="{{route('movies.toggle_favorite', $latest_movie->id )}}"
                                    data-movie_id={{ $latest_movie->id }}
                                    ></span> add to favorite
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light text-capitalize"><span class="fa fa-lg fa-heart-o "></span> add to favorite</a>
                                @endauth
                            </div>
                        </div><!-- end of col -->

                        <div class="col-6 mt-2 mx-auto col-md-4 col-lg-3  ml-md-auto mr-md-0">
                            <img src="{{ url('uploads/pictures/'.$latest_movie->poster) }}" class="img-fluid" alt="">
                        </div>
                    </div><!-- end of row -->

                </div><!-- end of container -->

            </div><!-- end of movie -->

            @endforeach

        </div><!-- end of movies -->

    </section><!-- end of banner section-->

    @foreach ($categories as $category)

    <section class="listing py-2">

        <div class="container">

            <div class="row my-4">
                @if ( $category->movies->count() )
                <div class="col-12 d-flex justify-content-between">
                    <h3 class="listing__title text-white fw-300">{{ $category->name }}</h3>
                    <a href="{{ route('movies.all', ['category_name' => $category->name]) }}" class="align-self-center text-capitalize text-primary">see all</a>
                </div>
                @endif
            </div><!-- end of row -->

            <div class="movies owl-carousel owl-theme">

                <?php $count = 0; ?>

                @foreach ($category->movies as $movie)

                <?php if($count == 10) break; ?>

                <div class="movie p-0">
                    <img src="{{ url('uploads/pictures/'.$movie->poster) }}" class="img-fluid" alt="">

                    <div class="movie__details text-white">

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

                <?php $count++; ?>

                @endforeach

            </div><!-- end of row -->



        </div><!-- end of container -->

    </section><!-- end of listing section -->

    @endforeach

    @include('layouts._footer')
@endsection
