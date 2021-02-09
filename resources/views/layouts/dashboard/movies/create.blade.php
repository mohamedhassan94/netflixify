@extends('layouts.dashboard.app');

@section('content')
<script src="{{ asset('dashboard/js/jquery-3.3.1.min.js') }}"></script>

<h2>movies</h2>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('movies.index') }}">Movies</a></li>
        <li class="breadcrumb-item active">Add</li>

    </ul>

<div class="row">
    <div class="col-md-12">
        <div class="tile mb-4">

            <div id="upload_section" onclick=" $('#movie_file_input').click(); ">
                <i class="fa fa-video-camera fa-2x"></i>
                <p>click to upload</p>
            </div>

            <div id="uploadStatus"></div>
            <strong class="text-danger" id="path_error"></strong>

            <form action="{{ route('movies.store') }}" id="movieForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group my-2 d-none">
                    <input type="file" name="path" class="form-control" id="movie_file_input" />
                </div>
            </form>


            <div class="progress_section">
                <label id="progress_status-text">Uploading</label>
                <div class="progress">
                    <div class="progress-bar" id="movie_upload_progress" role="progressbar"></div>
                </div>
            </div>

            <form id="movie-data" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                    <input type="hidden" id="movie-id" name="id" class="form-control my-2"/>
                    <input type="hidden" name="type" value="publish" class="form-control my-2"/>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name_input" class="form-control">
                        <strong class="text-danger" id="name_error"></strong>
                    </div>

                    <div class="form-group">
                        <label>Description</label> <strong class="ml-2 text-info text-bold">Max 500 Characters</strong>
                        <textarea name="description" rows="5" class="form-control"></textarea>
                        <strong class="text-danger" id="description_error"></strong>
                    </div>

                    <div class="form-group">
                        <label>Movie Poster</label>
                        <input type="file" name="poster" class="form-control">
                        <strong class="text-danger" id="poster_error"></strong>
                    </div>

                    <div class="form-group">
                        <label>Movie Background</label>
                        <input type="file" name="image" class="form-control">
                        <strong class="text-danger" id="image_error"></strong>
                    </div>

                    <div class="form-group">
                        <label>Categories</label><br>
                        <select name="categories[]" class="form-control select2" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <strong class="text-danger" id="categories_error"></strong>
                    </div>

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" class="form-control">
                        <strong class="text-danger" id="year_error"></strong>
                    </div>


                    <div class="form-group">
                        <label>Rating</label>
                        <input type="number" name="rating" class="form-control">
                        <strong class="text-danger" id="rating_error"></strong>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="publish_movie_btn" class="btn btn-primary"><i class="fa fa-plus"></i>Publish</button>
                    </div>

            </form>

        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // File upload via Ajax

        $("#movie_file_input").on('change', function(e){

            // resetting movie validation tag before the Ajax start working

            $('#path_error').text('');
            $('#uploadStatus').html('');

            $('.progress_section').css('display', 'block');
            $('#upload_section').css('display', 'none');
            var movieForm = new FormData( $('#movieForm')[0] )


            $.ajax({
                type: 'POST',
                url: '{{ route('movies.store') }}',
                enctype: 'multipart/form-data',
                data: movieForm,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".progress-bar").width('0%');
                },
                success: function(movie){
                    let movie_id = movie.id;
                    $('#movie-id').val(movie_id);  // getting the id of the movie

                    var interval = setInterval(function(){
                        $.ajax({
                            url: movie_id,
                            type: 'GET',
                            success: function(movieWhileProcessing){
                                console.log(movieWhileProcessing.percent);
                                console.log(movieWhileProcessing.percent);
                                $('#progress_status-text').html('Processing');
                                $(".progress-bar").css('width', movieWhileProcessing.percent + '%');
                                $(".progress-bar").html(movieWhileProcessing.percent +'%');

                                if(movieWhileProcessing.percent == 100){
                                    clearInterval( interval );
                                    $('#progress_status-text').html('Processing Done').attr('class', 'text-success');
                                    $(".progress").css('display', 'none');
                                    $('#publish_movie_btn').css('display', 'block');
                                    $('#movie-data').attr('action', movie_id);
                                }
                            }
                        })
                    }, 3000)

                },
                xhr: function() {

                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            $(".progress-bar").width(percentComplete + '%');
                            $(".progress-bar").html(percentComplete+'%');
                        }
                    }, false);

                    return xhr;

                },
                error:function(reject){
                    $(".progress").css('display', 'none');
                    $("#progress_status-text").css('display', 'none');
                    $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please reload the page and try again.</p>');
                    var response = $.parseJSON(reject.responseText);
                    $.each( response.errors, function(key, val){
                        $('#' + key + '_error').text(val[0]);
                    } )
                }
            });


        });



        $('#publish_movie_btn').click( function(e){
            e.preventDefault();

            // resetting all small tags before the Ajax start working

            $('#name_error').text('');
            $('#description_error').text('');
            $('#poster_error').text('');
            $('#image_error').text('');
            $('#categories_error').text('');
            $('#year_error').text('');
            $('#rating_error').text('');

            var movie_data_Form = new FormData( $('#movie-data')[0] ); // receive all data from the form and receive it in a variable

            var movie_id = $('#movie-data').attr('id');  // getting the id of the movie
            $.ajax( {
                type: 'post',
                url: '{{ route('movies.update', 'movie_id') }}',
                enctype: 'multipart/form-data',  // because we will upload files
                data: movie_data_Form,  // the form data
                processData: false,
                contentType: false,
                cache: false,
                success: function(data){
                    window.location = '{{ route('movies.index') }}';
                },
                error: function(reject){
                    var response = $.parseJSON(reject.responseText);
                    $.each( response.errors, function(key, val){
                        $('#' + key + '_error').text(val[0]);
                    } )
                }
            } )
        } )


    });
</script>




@endsection
