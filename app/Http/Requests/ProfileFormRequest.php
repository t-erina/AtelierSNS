<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
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
            'icon' => 'nullable|image|mimes:jpeg,png,gif',
            'profile' => 'nullable|between:1,400|string',
        ];
    }

    public function messages()
    {
        return [
            'icon.image' => '画像ファイルを選択してください',
            'icon.mimes' => '使用できるファイル形式はjpeg, png, gifです',
            'profile.between' => ':attributeは400字以内で入力してください',
            'profile.string' => '不適切な記号が含まれています',
        ];
    }

    public function attributes()
    {
        return [
            'icon' => 'アイコン画像',
            'profile' => 'プロフィール',
        ];
    }
}
