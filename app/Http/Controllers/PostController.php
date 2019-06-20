<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Validator;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

	public function index()
	{
		// $posts  = Post::select('posts.*','categories.slug as category_slug')->join('categories','categories.id','=','posts.category_id')->paginate(6);
		$posts = Post::orderBy('id','desc')->paginate(10);
		$lastest_posts = Post::orderBy('id','desc')->limit(3)->get();
		$tags = \App\Tag::get();
		return view('posts.index',['posts' => $posts,'lastest_posts'=>$lastest_posts,'tags'=>$tags]);
	}

	public function detail($slug)
	{
		$post = Post::where('slug',$slug)->FirstOrFail();

		$user = \App\User::where('id',$post->user_id)->FirstOrFail();

		$tags_post  = \DB::table('post_tags')
							->join('tags','post_tags.tag_id','=','tags.id')
							->join('posts','post_tags.post_id','=','posts.id')
							->where('posts.slug', '=', $slug)
							->get();

		$post_categories = $post->categories;

		return view('posts.detail',['post' => $post,'post_categories' => $post_categories,'user' => $user,'tags_post' => $tags_post]);
	}

	public function category($slug)
	{
		$category = \App\Category::where('slug',$slug)->FirstOrFail();
		$tags = \App\Tag::get();

		$posts_category  = \DB::table('posts_category')
							->join('categories','posts_category.category_id','=','categories.id')
							->join('posts','posts_category.post_id','=','posts.id')
							->where('categories.slug', '=', $slug)
							->paginate(6);

		return view('categories.index',['posts_category' => $posts_category,'category' => $category,'tags'=>$tags]);
	}

	public function tag($slug)
	{
		$tag = \App\Tag::where('slug',$slug)->FirstOrFail();

		$posts_tag = $tag->posts;
		$tags = \App\Tag::get();

		return view('tags.index',['tags' => $tags,'tag' => $tag,'posts_tag' => $posts_tag]);
	}

	public function getFormTest()
	{
		return view('test');
	}

	public function test(PostRequest $request)
	{
		return view('test', ['errors' => $request->ViewErrorBag]);
		//$input = $request->all();
		// $validator = Validator::make($input, 
		// [
		// 	'title' => 'required|unique:posts|max:255',
  //           'description' => 'required',
  //           'slug' => 'required',
  //           'content' => 'required',
		// ],
		// [
  //           'required' => ':attribute Không được để trống',
  //           'min' => ':attribute Không được nhỏ hơn :min',
  //           'max' => ':attribute Không được lớn hơn :max'
  //       ],
  //       [
  //           'title' => 'Tiêu đề',
  //           'description' => 'Mô tả',
  //           'content' => 'Nội dung'
  //    ]
  // );

		// if ($validator->fails()) {
		// 	return redirect()->back()
  //                       ->withErrors($validator)
  //                       ->withInput();        
		// }
      
	}

}
