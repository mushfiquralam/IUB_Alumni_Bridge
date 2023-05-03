<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Post;
use App\Models\Query;
use App\Models\Job;
use App\Models\Event;
use App\Models\Award;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class postViewController extends Controller
{

    public function viewPost()
    {
        $posts = Post::latest('postDateTime')->get();
        return $posts;
    }
    
}
