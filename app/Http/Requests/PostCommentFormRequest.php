<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentFormRequest extends FormRequest
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
            'comment' => 'required|between:1,400|string',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => ':attributeを入力してください',
            'comment.between' => ':attributeは400字以内で入力してください',
            'comment.string' => '不適切な記号が含まれています',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'コメント'
        ];
    }
}
