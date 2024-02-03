<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserUpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function updateUsername(Request $request)
    {
        $rules = [
            'user_name' => 'required|between:1,20|string',
        ];
        $messages = [
            'user_name.required' => 'ユーザー名を入力してください',
            'user_name.between' => 'ユーザー名は20字以内で入力してください',
            'user_name.string' => '不適切な記号が含まれています',
        ];

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $getUsers = new User;
        $getUsers->updateUsername($validator['user_name']);
        $request->session()->flash('message', 'ユーザー名を変更しました');

        return redirect(route('userEditForm'));
    }

    public function updateEmail(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users|email|between:1,50',
        ];
        $messages = [
            'email.required' => 'メールアドレスを入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.between' => 'メールアドレスは50字以内で入力してください',
        ];

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $getUsers = new User;
        $getUsers->updateEmail($validator['email']);
        $request->session()->flash('message', 'メールアドレスを変更しました');

        return redirect(route('userEditForm'));
    }

    public function updatePassword(Request $request)
    {
        if (Auth::check()) {
            $currentPassword = Auth::user()->password;

            $passCheck = Hash::check($request->input('password'), $currentPassword);

            Validator::make(['password' => $passCheck], ['password' => 'accepted'], ['password.accepted' => 'パスワードが違います'])->validate();

            $rules = [
                'password' => 'required',
                'newpassword' => 'required|between:8,30|regex:/^[a-zA-Z0-9]+$/|confirmed',
            ];
            $messages = [
                'password.required' => '現在のパスワードを入力してください',
                'newpassword.required' => '新しいパスワードを入力してください',
                'newpassword.between' => '新しいパスワードは8文字以上30字以内で入力してください',
                'newpassword.regex' => '半角英数字で入力してください',
                'newpassword.confirmed' => 'パスワードが一致しません',
            ];

            $validator = Validator::make($request->all(), $rules, $messages)->validate();

            $getUsers = new User;
            $getUsers->updateEmail(Hash::make($validator['password']));
            $request->session()->flash('message', 'パスワードを変更しました');
        } else {
            $request->session()->flash('message', '再度ログインしてください');
        }
        return redirect(route('userEditForm'));
    }
}
