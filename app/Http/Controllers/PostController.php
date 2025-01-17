<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user'])->orderBy('created_at', 'DESC')->get();        
        return view('posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {        
        // Validate the request
        $validated = $request->validated();
        $file = $request->file('image');
        if ( isset( $file ) ) {           
            
            $file_extension = $file->extension();
            $file_name = 'img_'. Str::random(10) . '.' . $file_extension;  
            
            $path = $request->file('image')->storeAs('posts', $file_name, 'public' );
            $validated['image'] = $path;
        }
        
        Post::create($validated);
        $posts = Post::with(['user'])->orderBy('created_at', 'DESC')->get(); 
        
        // Redirect to the intended page or to a default route (e.g., '/home')
        return redirect()->intended('/home')->with('success', 'Your post added successfully!');           
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Validate the request
        $validated = $request->validated();
        $post->update( $validated );
        $posts = Post::with(['user'])->orderBy('created_at', 'DESC')->get();
        return redirect()->route('posts.index', ['posts' => $posts]);        
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('posts.index');
    }
}
