<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use \Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.list');
    }

    public function getListCategories()
    {
        //Lấy tất cả các bài biết trong bảng categories và sắp xếp theo thứ tự giảm dần
        $categories = Category::orderBy('id', 'desc')->get();

        return Datatables::of($categories)
        //thêm cột stt tự tăng
        ->addIndexColumn()
        //thêm cột chức năng với các nút thêm sửa xóa
        ->addColumn('action', function ($category) {
            return 
            '<button style="width: 30px; height: 30px" data-id="'.$category->id.'" data-url="'.route('categories.edit',$category->id).'"​ class="btn btn-edit btn-xs btn-warning " ><i class="fa fa-pencil"></i></button>
            <button style="width: 30px; height: 30px" data-url="'.route('categories.destroy',$category->id).'"​ class="btn btn-xs btn-danger btn-delete" ><i class="fa fa-trash"></i></button>
            ';
        })
        //thêm cột tiêu đề với giá trị là cột title trong bảng categories
        ->editColumn('name', function ($category) {
            return $category->name;
        })
        //thêm cột mô tả với giá trị là cột title trong bảng categories
        ->editColumn('description', function ($category) {
            return Str::words($category->description,25,'...');
        })
        //thêm cột danh mục cha với giá trị là cột parent_id trong bảng categories
        ->editColumn('parent', function ($category) {
            if ($category->parent_id == null) {
                return 'Không có danh mục cha';
            } else {
                $parent_category = Category::select('name')->where('id', $category->parent_id)->first();
                return $parent_category['name'];
            }
        })
        //thêm cột hình ảnh với giá trị là cột title trong bảng thumbnail
        ->editColumn('thumbnail', function ($category) {
            return '<img src="' . $category->thumbnail . '" width="100px" height="100px">';
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

        return response()->json([
            'categories' => $categories
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $path = '';
        $date = date('YmdHis');
        if ($request->thumbnail) {
            $thumbnail = $request->thumbnail->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('/images/categories', $date . '_' . $thumbnail);
        }
        $parent_id = null;
        if ($request->parent_id != 'null') {
            $parent_id = $request->parent_id;
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $request->slug,
            'parent_id' => $parent_id,
            'thumbnail' => env('APP_URL').'storage/'.$path
        ]);
        
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'category' => $category,
            'categories' => $categories
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
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

        $parent_id = null;
        if ($request->parent_id != 'null') {
            $parent_id = $request->parent_id;
        }

        Category::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $request->slug,
            'parent_id' => $parent_id,
            'thumbnail' => $path
        ]);
        
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
        $category = Category::where('id', $id)->first();
        $cate = Category::where('parent_id', $category->id);
        foreach ($cate->get() as $value) {
            $post = Post::whereBetween('category_id', array($category->id, $value->id))->delete();
        }
        $cate->delete();
        $category->delete();
        return response()->json(['success' => 'Xóa thành công'], 200);
    }
}
