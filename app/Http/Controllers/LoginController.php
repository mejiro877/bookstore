<?php

namespace App\Http\Controllers;

use App\Models\OnlineMember;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $keys = parse_url(url()->previous());
        $path = explode("/", $keys['path']);
        $last = end($path);
        session(['last' => $last]);
        return view('ecsite.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'member_no' => 'required|integer',
            'password' => 'required|max:8|alpha_num',
        ]);

        $onlineMember = OnlineMember::where('MEMBER_NO', $request->member_no)->first();

        if (isset($onlineMember) && $onlineMember->PASSWORD === $request->password && $onlineMember->DELETE_FLG == 0) {
            session(['member_no' => $onlineMember->MEMBER_NO]);
            session(['name' => $onlineMember->NAME]);
            session()->flash('flash_flg', 1);
            session()->flash('flash_msg', 'ログインしました。');
            if (session('last') == "buycheck") {
                return redirect()->route('ecsite.buycheck');
            }
            return redirect()->route('ecsite.menu');
        } else {
            $loginFail = 'ログインできませんでした。';
            return view('ecsite.login', compact('loginFail'));
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('ecsite.menu');
    }
}
