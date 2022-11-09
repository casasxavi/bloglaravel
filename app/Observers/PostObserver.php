<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    public function creating(Post $post)
    {

        if (!app()->runningInConsole()) {


            $post->user_id = Auth()->id();
        }
    }

    public function updating(Post $post)
    {
        if ($post->is_published && is_null($post->published_at)) {
            $post->published_at = now();
        }
    }
}
