<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            $slug_rules = 'required|unique:tags,slug,' . $this->id;
        } else {
            $slug_rules = 'required|unique:tags,slug';
        }

        return [
            'name' => 'required',
            'slug' => $slug_rules
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
            'name' => 'Tiêu đề',
       ];
   }
}
