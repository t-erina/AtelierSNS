<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
            'user_name' => 'required|between:1,20|string',
            'email' => 'required|unique:users|email|between:1,50',
            'password' => 'required|between:8,30|regex:/^[a-zA-Z0-9]+$/|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => ':attributeを入力してください',
            'user_name.between' => ':attributeは20字以内で入力してください',
            'user_name.string' => '不適切な記号が含まれています',
            'email.required' => ':attributeを入力してください',
            'email.unique' => 'この:attributeは既に登録されています',
            'email.email' => ':attributeの形式で入力してください',
            'email.between' => ':attributeは50字以内で入力してください',
            'password.required' => ':attributeを入力してください',
            'password.between' => ':attributeは8文字以上30字以内で入力してください',
            'password.regex' => ':attributeは半角英数字で入力してください',
            'password.confirmed' => ':attributeが一致しません',
        ];
    }

    public function attributes()
    {
        return [
            'user_name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }
}
