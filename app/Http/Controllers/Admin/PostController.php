<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


/* use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; */

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::where('user_id', Auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(4);


        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'category_id' => 'required|integer|exists:categories,id',
            'content' => 'required|string'
        ]);

        $post = Post::create($request->all());

        session()->flash('flash.banner', 'El post se ha creado con éxito');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin.posts.edit', compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));

        /* $tags = Tag::all(); */
        /* return view('admin.posts.edit', compact('post', 'categories', 'tags')); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {

        $tags = [];

        foreach ($request->tags as $name) {

            $tag = Tag::firstOrCreate(['name' => $name]);

            $tags[] = $tag->id;

        }


        $post->tags()->sync($tags);

        $post->update($request->all());

        if ($request->hasFile('image')) {

            if ($post->image_url) {
                Storage::delete($post->image_url);
            }

            $nameFile = Str::slug($request->title) . '.' . $request->image->extension();

            $image_url = Storage::putFileAs('posts', $request->image, $nameFile);

            $post->image_url = $image_url;
            $post->save();

            /* $image_url = Storage::put('posts', $request->file('image'));

            $post->image_url = $image_url;
            $post->save(); */
        }

        session()->flash('flash.banner', 'El post se ha editado con éxito');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin.posts.edit', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        session()->flash('flash.banner', 'El post se ha eliminado con éxito');
        session()->flash('flash.bannerStyle', 'danger');

        return redirect()->route('admin.posts.index');
    }
}
