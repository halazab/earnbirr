<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $pageTitle = 'Login';
        return view('templates.basic.user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $request->username, 'password' => $request->password])) {
            $user = auth()->user();
            if ($user->status == 0) {
                Auth::logout();
                return back()->withErrors(['Your account has been banned.']);
            }
            $this->saveLoginLog($user);
            return redirect()->route('user.tasks.index');
        }

        return back()->withErrors(['Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    protected function saveLoginLog($user)
    {
        $login = new UserLogin();
        $login->user_id = $user->id;
        $login->ip = request()->ip();
        $login->browser = request()->userAgent();
        $login->os = php_uname('s');
        $login->save();
    }
}
