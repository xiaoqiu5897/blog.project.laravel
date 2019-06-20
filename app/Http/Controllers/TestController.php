<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Yajra\Datatables\Datatables;

class TestController extends Controller
{
    public function index()
    {
    	return view('test');
    }

    public function getListPosts()
    {
    	$posts = Post::orderBy('id', 'desc')->get();

    	return Datatables::of($posts)
    		->addIndexColumn()
            ->addColumn('action', function ($post) {
                return 
                '<a class="btn btn-xs btn-primary" data-id="'.$post->id.'"><i class="glyphicon glyphicon-edit"></i> Detail</a>
                <a class="btn btn-xs btn-primary" data-id="'.$post->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-xs btn-primary" data-id="'.$post->id.'"><i class="glyphicon glyphicon-edit"></i> Delete</a>';
            })
            ->editColumn('title', function ($post)
            {
            	return $post->title;
            })
            ->editColumn('content', function ($post)
            {
            	return $post->content;
            })
            ->editColumn('thumbnail', function ($post)
            {
            	return '<img width="200px" height="200px" src="'.$post->thumbnail.'">';
            })
            ->rawColumns(['thumbnail', 'action', 'content'])
            ->make(true);
    }

    public function getTag()
    {
        $tags = Tag::select('id', 'name')->get();
        return response()->json(['tags' => $tags]);
    }
}
