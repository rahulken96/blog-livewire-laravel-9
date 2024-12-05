<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $data = [
            'categories' => Category::take(10)->get(),
        ];

        return view('post.index', $data);
    }
}
