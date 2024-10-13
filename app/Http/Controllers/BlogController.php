<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\StoreBlogRequest;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function __construct() {
        // $this->middleware('auth')->only(['create']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Check if user is authenticated
        if (Auth::check()) {
            // Fetch all categories for dropdown in the create blog form
            $categories = Category::get();
            return view('theme.blogs.create', compact('categories'));
        }
        abort(403);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        // Image Uploading
        // First - Get The Image
        $image = $request->file('image');
        // Second - change it's current name to avoid dubplicate idea to ensure accuracy
        $newImageName = time(). '.'. $image->getClientOriginalName();
        // Third - Upload it to a temporary location - move the image to my project
        // $image->move(public_path('images'), $imageName);
        $image->storeAs('blogs', $newImageName, 'public');
        // Finally - Save it with its new name to the database record
        $data['image'] = $newImageName;
        $data ['user_id'] = Auth::user()->id;
        

        Blog::create($data);

        return back()->with('blogCreateStatus', 'Blog Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
