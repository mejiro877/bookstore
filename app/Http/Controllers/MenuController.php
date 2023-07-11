<?php

namespace App\Http\Controllers;

use App\Models\OnlineMember;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $values = OnlineMember::all();

        $members = DB::table('online_member')
            ->select('MEMBER_NO')
            ->get();

        return view('ecsite.menu', compact('members'));
    }
}
