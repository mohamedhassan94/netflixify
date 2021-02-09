<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Jobs\StreamMovie;
use App\Models\Category;
use App\Models\Movie;
use App\Traits\SaveImage;
use App\Traits\SaveMovie;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use SaveMovie;
    use SaveImage;

    public function __construct()
    {
        $this->middleware('permission:read_movies')->only([ 'index' ]);
        $this->middleware('permission:create_movies')->only([ 'create' , 'store' ]);
        $this->middleware('permission:update_movies')->only([ 'edit' , 'update']);
        $this->middleware('permission:delete_movies')->only(['destroy']);
    }


    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $movies = Movie::search($searchTerm)->paginate(20);
        $arr['movies'] = $movies;
        return view('layouts.dashboard.movies.index', $arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $arr['categories'] = $categories;

        return view('layouts.dashboard.movies.create', $arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(MovieRequest $request)
    {
        $path = $this->saveMovie($request->path, 'all_movies', 'movies');
        $movie = Movie::create([
            'path' => $path,
            'name' => $request->path->getClientOriginalName() // just in case the user didn't fill the movie-data form
        ]);

        if($movie){
                // executing the job of encoding process in the background
            $this->dispatch( new StreamMovie($movie) );

                // return the movie id to the create view to use it in the movie data form
            return response()->json($movie);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return $movie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $arr['movie'] = $movie;
        $categories = Category::all();
        $arr['categories'] = $categories;
        return view('layouts.dashboard.movies.edit', $arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($request->id) ;

        if($request->type === 'publish' || $movie->description == null){

            $request_data = $request->except( ['poster', 'image'] );


            $request->validate([
                'name' => "required|unique:movies,name,$movie->id",
                'description' => "required|max:500",
                'poster' => "required|image|mimes:jpeg,jpg,png",
                'image' => "required|image|mimes:jpeg,jpg,png",
                'categories' => "required",
                'year' => 'required|integer|min:1900|max:2020',
                'rating' => 'required|numeric|min:1|max:5',
            ]);


            $image = $this->saveImage($request->file('image'), 'images', 'pictures');
            $poster = $this->saveImage($request->file('poster'), 'posters', 'pictures');

            $request_data['poster'] = $poster;
            $request_data['image'] = $image;

            $movie->update($request_data);
            $movie->categories()->sync($request->categories);

            // resizing the poster after saving it
            Image::make( public_path('uploads/pictures/'.$movie->poster) )->resize(255, 378)->save();

            // minimize the quality of the image by 50% after saving it
            Image::make( public_path('uploads/pictures/'.$movie->image) )->save( public_path('uploads/pictures/'.$movie->image), 50 );

            return redirect( route('movies.index') )->with('message', 'Movie updated successfully');

        }else{

            $request_data = $request->except( ['poster', 'image'] );

            $request->validate([
                'name' => "required|unique:movies,name,$movie->id",
                'description' => "required|max:500",
                'poster' => "sometimes|image|mimes:jpeg,jpg,png",
                'image' => "sometimes|image|mimes:jpeg,jpg,png",
                'categories' => "required",
                'year' => 'required|integer|min:1900|max:2020',
                'rating' => 'required|numeric|min:1|max:5',
            ]);

            if($request->poster){
                $poster = $this->saveImage($request->poster, 'posters', 'pictures');
                    if($movie->poster != null){
                        unlink( public_path('uploads/pictures/'.$movie->poster) );
                    }
                $request_data['poster'] = $poster;
            }

            if($request->image){
                $image = $this->saveImage($request->image, 'images', 'pictures');
                if($movie->image != null){
                    unlink( public_path('uploads/pictures/'.$movie->image) );
                }
                $request_data['image'] = $image;
            }

            $movie->update($request_data);
            $movie->categories()->sync($request->categories);

            // resizing the poster after saving it
            Image::make( public_path('uploads/pictures/'.$movie->poster) )->resize(255, 378)->save();

            // minimize the quality of the image by 50% after saving it
            Image::make( public_path('uploads/pictures/'.$movie->image) )->save( public_path('uploads/pictures/'.$movie->image ), 50 );

            return redirect( route('movies.index') )->with('message', 'Movie updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        // deleting the encoded movie folder
        if($movie->path != null){
            File::deleteDirectory( public_path('uploads/movies/'.$movie->id) );  // import this namespace above  ==> use Illuminate\Support\Facades\File;
        }

        // deleting the original movie
        if($movie->path != null){
            File::delete( public_path('uploads/movies/'.$movie->path) );
        }

        // deleting the poster and the image
        if($movie->poster != null){
            unlink( public_path('uploads/pictures/'.$movie->poster) );
        }

        if($movie->image != null){
            unlink( public_path('uploads/pictures/'.$movie->image) );
        }

        // deleting the movie record from the database
        $movie->delete() ;

        return redirect( route('movies.index') )->with('message','Movie deleted successfully');
    }
}
