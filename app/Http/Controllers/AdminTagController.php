<?php

namespace App\Http\Controllers;

use App\Tag;
use Yajra\Datatables\Datatables;
use App\Http\Requests\TagRequest;
use Illuminate\Http\Request;

class AdminTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tags.list');
    }

    public function getListTags()
    {
        //Lấy tất cả các bài biết trong bảng categories và sắp xếp theo thứ tự giảm dần
        $tags = Tag::orderBy('id', 'desc')->get();

        return Datatables::of($tags)
        //thêm cột stt tự tăng
        ->addIndexColumn()
        //thêm cột chức năng với các nút thêm sửa xóa
        ->addColumn('action', function ($tag) {
            return 
            '<button style="width: 30px; height: 30px" data-parent-id="' . $tag->id . '" data-url="'.route('tags.show',$tag->id).'"​ class="btn btn-show btn-xs btn-success " ><i class="fa fa-eye"></i></button>
            <button style="width: 30px; height: 30px" data-id="'.$tag->id.'" data-url="'.route('tags.edit',$tag->id).'"​ class="btn btn-edit btn-xs btn-warning " ><i class="fa fa-pencil"></i></button>
            <button style="width: 30px; height: 30px" data-url="'.route('tags.destroy',$tag->id).'"​ class="btn btn-xs btn-danger btn-delete" ><i class="fa fa-trash"></i></button>
            ';
        })
        //thêm cột tiêu đề với giá trị là cột title trong bảng tags
        ->editColumn('name', function ($tag) {
            return $tag->name;
        })
        //thêm cột slug với giá trị là cột slug trong bảng tags
        ->editColumn('slug', function ($tag) {
            return $tag->slug;
        })
        //những cột có các thẻ html thì thêm vào hàm rawColumns thì các thẻ html này mới hiển thị 
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json(['tag' => $tag], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);

        return response()->json([
            'tag' => $tag, 
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
        $tag = Tag::find($id);

        return response()->json([
            'tag' => $tag, 
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Tag::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $request->slug
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
        Tag::where('id', $id)->delete();
        return response()->json(['success' => 'Xóa thành công'], 200);
    }
}
