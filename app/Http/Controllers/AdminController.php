<?php

namespace App\Http\Controllers;


use App\Exports\ResultExport;
use http\Exception\BadConversionException;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function auth(Request $request){
        $validated = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
        $admin = DB::table('admins')
            ->where('login', $request->login)
            ->where('password', $request->password)
            ->first();
        if (!empty($admin)){
            session()->put('admin', 1);
            return redirect(route('home'));
        }
        else{
            return back();
        }
    }


    public function home(){
        $blocks = DB::table('blocks')
            ->latest()
            ->get();
        return view('home', ['blocks' => $blocks]);
    }

    public function export($id){
        return Excel::download(new ResultExport($id), 'natijalar.xlsx');
    }

    public function add(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'count' => 'required',
            'answers' => 'required',
        ]);

        if ($request->count != strlen($request->answers)){
            return back()->with('data_error', 1);
        }

        DB::table('blocks')
            ->insert([
                'name' => $request->name,
                'length' => $request->count,
                'answers' => $request->answers,
            ]);
        return back()->with('data', 0);
    }
}
