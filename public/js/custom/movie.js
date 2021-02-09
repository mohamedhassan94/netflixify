$(document).ready(function(){

    let fav_count = $('#nav__fav_count').data('fav_count');
    fav_count > 9 ? $('#nav__fav_count').html('9+') : $('#nav__fav_count').html(fav_count);


    function toggleFavorite(url, isFavored, movie_id){

        if(isFavored){
            fav_count-- ;
        }else{
            fav_count++ ;
        };

        fav_count > 9 ? $('#nav__fav_count').html('9+') : $('#nav__fav_count').html(fav_count);

        $('.movie-' + movie_id).toggleClass('fa-heart');
        $('.movie-' + movie_id).toggleClass('fa-heart-o');

        $.ajax({
            url: url,
            method: 'POST',
            success: function(){

            }
        });

    };

    $(document).on('click', '.movie__fav-button', function(){

        let url = $(this).data('url');
        let isFavored = $(this).hasClass('fa-heart');
        let movie_id = $(this).data('movie_id');

        toggleFavorite(url, isFavored, movie_id);

    });

    $(document).on('click', '.add-to-favorite-btn', function(){

        let url = $(this).find('.movie__fav-button').data('url');
        let isFavored = $(this).find('.movie__fav-button').hasClass('fa-heart');
        let movie_id = $(this).find('.movie__fav-button').data('movie_id');

        toggleFavorite(url, isFavored, movie_id);

    });

    $(document).on('click', '.favorite-movie', function(){

        let movie_id = $(this).data('movie_id');

        $('#favorite-' + movie_id).remove();

    })


})

