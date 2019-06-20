<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return view('demoUpload');
    }

    public function upload(Request $request)
    {
        //Kiểm tra file có tồn tại hay không
        if ($request->hasFile('file')) {
        	//Lấy ra tất cả thông tin của file
            $file = $request->file;
            //Lấy Tên file
            $name_file = $file->getClientOriginalName();
            //Lưu file vào storage, đường dẫn storage/app/public/images/ten_file
            $path = $file->storeAs('images', $name_file);

            return view('demoUpload', ['path' => $path]);
            //return response()->json(['path' => $path]);
        }
    }
}
