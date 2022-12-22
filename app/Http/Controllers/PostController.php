<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequset;
use App\Http\Requests\PostUpdateRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts', [
            'posts' => Post::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequset $request)
    {
        $post = Post::create($request->validated());
        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->usingName(Str::slug($post->title))
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }
        if ($request->hasFile('download')) {
            $post->addMediaFromRequest('download')
                ->usingName(Str::slug($post->title))
                ->toMediaCollection('downloads');
        }
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->update($request->validated());
        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->usingName(Str::slug($post->title))
                ->withResponsiveImages()
                ->nonQueued()
                ->toMediaCollection('images');
        }
        if ($request->hasFile('download')) {
            $post->clearMediaCollection('downloads');
            $post->addMediaFromRequest('download')
                ->usingName(Str::slug($post->title))
                ->toMediaCollection('downloads');
        }
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
    public function downloadMedia($id)
    {
        $post = Post::find($id);
        $media = $post->getFirstMedia('downloads');
        return $media;
    }
    public function downloadDownloadMedia()
    {
        $media = Media::where('collection_name', 'downloads')->get();
        if ($media) {
            return MediaStream::create('downloads.zip')->addMedia($media);
        }
        return redirect()->back();
    }
    public function downloadAllMedia()
    {
        $media = Media::all();
        if ($media) {
            return MediaStream::create('allMedia.zip')->addMedia($media);
        }
        return redirect()->back();
    }
}
