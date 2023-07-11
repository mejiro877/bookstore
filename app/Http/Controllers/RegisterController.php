<?php

namespace App\Http\Controllers;

use App\Models\OnlineMember;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $formItems = ["name", "password", "age", "sex", "zip", "address", "tel"];

    public function index()
    {
        return view('ecsite.register');
    }

    public function check(Request $request)
    {
        $input = $request->session()->get("form_input");

        if (!$input) {
            return redirect()->action("ecsite.register");
        }

        return view('ecsite.registercheck', ["input" => $input]);
    }

    public function end()
    {
        return view('ecsite.registerend');
    }

    public function register(Request $request)
    {
        $input = $request->only($this->formItems);

        $registMember = new OnlineMember;
        $this->validate($request, [
            'name' => 'required|max:20',
            'password' => 'required|max:8|alpha_num|confirmed',
            'password_confirmation' => 'required|max:8|alpha_num',
            'age' => 'required|numeric|positive_integer',
            'sex' => 'required',
            'zip' => 'required|zip_code',
            'address' => 'required|max:50',
            'tel' => 'required|tel|max:20',
        ]);

        $request->session()->put("form_input", $input);

        return redirect('ecsite/registercheck');
    }

    public function send(Request $request)
    {
        $input = $request->session()->get("form_input");

        if (!$input) {
            return redirect()->action("ecsite.register");
        }

        $registMember = new OnlineMember;

        $members = OnlineMember::max('MEMBER_NO') + 1;
        $ndate = now()->format('Y-m-d');

        $registMember->member_no = $members;
        $registMember->name = $input['name'];
        $registMember->password = $input['password'];
        $registMember->age = $input['age'];
        $registMember->sex = $input['sex'];
        $registMember->zip = $input['zip'];
        $registMember->address = $input['address'];
        $registMember->tel = $input['tel'];
        $registMember->register_date = $ndate;

        $registMember->save();

        $request->session()->forget("form_input");
        $request->session()->put("members", OnlineMember::max('MEMBER_NO'));

        // return view('ecsite.registerend', compact('members'));
        return redirect('ecsite/registerend');
    }
}
