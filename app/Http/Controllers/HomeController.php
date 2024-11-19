<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('home', [
            'publishPosts' => Post::published()->isPublish()->latest('published_at')->take(3)->get(),
            'postTerbaru' => Post::isPublish()->latest('published_at')->take(9)->get(),
        ]);
    }
}
