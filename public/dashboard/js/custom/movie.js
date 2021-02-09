/* $(document).ready( function(){

    $('#movie_file_input').change(

        function(){

            $('#upload_section').css('display', 'none');

            var url = $(this).data('url');

            // var name = $('#name_input').val();


            // movieForm.append('name', name);
            // movieForm.append('path', movie);

            var movieForm = new FormData();

            var movie = $('#movie_file_input').val();

            movieForm.append('movie_id', movie_id);
            movieForm.append('path', movie);

            $.ajax( {
                type: 'POST',
                enctype: 'multipart/form-data',
                url: url ,
                data: movieForm ,
                processData: false ,
                contentType: false ,
                cache: false ,
                success: function(data){

                },
                xhr: function(){

                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener('progress', function(evt){
                        if(evt.lengthComputable){
                            var percentComplete = Math.round( evt.loaded / evt.total * 100 ) + '%' ;
                            $('#movie_upload_progress').css('width', percentComplete).html( percentComplete );
                        }
                    }, false);

                    return xhr ;

                }
            } )

        });

} ) */
