<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Post;
use App\Category;
use App\PostTag;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class AdminPostAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.list');
    }

    public function getListPosts()
    {
        //Lấy tất cả các bài biết trong bảng posts và sắp xếp theo thứ tự giảm dần
        $posts = Post::orderBy('id', 'desc')->get();

        return Datatables::of($posts)
        //thêm cột stt tự tăng
        ->addIndexColumn()
        //thêm cột chức năng với các nút thêm sửa xóa
        ->addColumn('action', function ($post) {
            return 
            '<button style="width: 30px; height: 30px" data-url="'.route('posts.show',$post->id).'"​ class="btn btn-show btn-xs btn-success " ><i class="fa fa-eye"></i></button>
            <button style="width: 30px; height: 30px" data-id="'.$post->id.'" data-url="'.route('posts.edit',$post->id).'"​ class="btn btn-edit btn-xs btn-warning " ><i class="fa fa-pencil"></i></button>
            <button style="width: 30px; height: 30px" data-url="'.route('posts.destroy',$post->id).'"​ class="btn btn-xs btn-danger btn-delete" ><i class="fa fa-trash"></i></button>
            ';
        })
        //thêm cột tiêu đề với giá trị là cột title trong bảng posts
        ->editColumn('title', function ($post) {
            return $post->title;
        })
        //thêm cột mô tả với giá trị là cột title trong bảng description
        ->editColumn('description', function ($post) {
            return Str::words($post->description,25,'...');
        })
        //thêm cột hình ảnh với giá trị là cột title trong bảng thumbnail
        ->editColumn('thumbnail', function ($post) {
            return '<img src="' . $post->thumbnail . '" width="100px" height="100px">';
        })
        //những cột có các thẻ html thì thêm vào hàm rawColumns thì các thẻ html này mới hiển thị 
        ->rawColumns(['thumbnail','action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $tags = Tag::get();
        return response()->json(['categories' => $categories, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $path = '';
        $date = date('YmdHis');
        if ($request->thumbnail) {
            $thumbnail = $request->thumbnail->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('/images/posts', $date . '_' . $thumbnail);
        }
        $user_id = Auth::id();
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'slug' => $request->slug,
            'thumbnail' => env('APP_URL').'storage/'.$path,
            'user_id' => $user_id,
            'category_id' => $request->category
        ]);

        if ($request->post_tag) {
            $tags = explode(",", $request->post_tag);
            foreach ($tags as $tag) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tag
                ]);
            }
        }
        
        return response()->json(['success' => 'Thêm mới thành công'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $user = $post->user->name;
        $category = Category::select('name')->where('id', $post->category_id)->first();
        $post_tags = $post->tags;

        return response()->json([
            'post' => $post, 
            'user' => $user, 
            'category' => $category, 
            'post_tags' => $post_tags
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        $post_tags = PostTag::select('tag_id')->where('post_id', $post->id)->get();
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        
        return response()->json([
            'post' => $post, 
            'post_tags' => $post_tags, 
            'categories' => $categories, 
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $path = '';
        $date = date('YmdHis');

        if ($request->edit_thumbnail) {
            $thumbnail = $request->edit_thumbnail->getClientOriginalName();
            $path = $request->edit_thumbnail->storeAs('/images/posts', $date . '_' . $thumbnail);
            $path = env('APP_URL').'storage/'.$path;
        } else {
            $path = $request->thumbnail;
        }

        $user_id = Auth::id();
        Post::where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'slug' => $request->slug,
            'thumbnail' => $path,
            'user_id' => $user_id,
            'category_id' => $request->category
        ]);

        if ($request->post_tag) {
            $tags = explode(",", $request->post_tag);
            foreach ($tags as $tag) {
                PostTag::where('post_id', $id)->updateOrCreate([
                    'post_id' => $id,
                    'tag_id' => $tag
                ]);
            }
        }
        
        return response()->json(['success' => 'Sửa thành công'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', $id)->forceDelete();
        PostTag::where('post_id', $id)->delete();
        return response()->json(['success' => 'Xóa thành công'], 200);
    }

    public function removePostTag(Request $request, $tag_id)
    {
        PostTag::where('post_id', $request->post_id)->where('tag_id', $tag_id)->delete();
    }
}
