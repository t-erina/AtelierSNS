<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
        return [
            'post' => 'required|between:1,400|string',
            'tag' => 'nullable|between:1,255|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            'post.required' => ':attributeを入力してください',
            'post.between' => ':attributeは400字以内で入力してください',
            'post.string' => '不適切な記号が含まれています',
            'tag.between' => ':attributeは20字以内で5つまで作成可能です',
            'tag.string' => '不適切な記号が含まれています',
            'image.image' => ':attributeを選択してください',
            'image.mimes' => '使用できるファイル形式はjpeg, png, gifです',
        ];
    }

    public function attributes()
    {
        return [
            'post' => '投稿内容',
            'tag' => 'タグ',
            'image' => '画像ファイル',
        ];
    }
}
