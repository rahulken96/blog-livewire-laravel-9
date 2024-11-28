<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $data = [
            'posts' => Post::take(5)->get(),
        ];

        return view('post.index', $data);
    }
}
