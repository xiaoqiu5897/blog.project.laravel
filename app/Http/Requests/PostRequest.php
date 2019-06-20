<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Kiểm tra xem thêm mới hay chỉnh sửa
        if ($this->method() == 'PUT') {
            $slug_rules = 'required|unique:posts,slug,' . $this->id;
        } else {
            $slug_rules = 'required|unique:posts,slug';
        }

        return [
            'title' => 'required',
            'description' => 'required',
            'slug' => $slug_rules,
            'content' => 'required',
            'thumbnail' => 'required',
            'category' => 'required',
        ];
    }

    public function messages ()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'unique' => ':attribute đã tồn tại',
        ];
    }
    
    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'content' => 'Nội dung',
            'thumbnail' => 'Ảnh',
            'category' => 'Danh mục'
       ];
   }

}
