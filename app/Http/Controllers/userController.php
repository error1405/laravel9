<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    //
    function search_book(){
        $data = DB::table('lms_book')->where('book_status','Enable')->orderBy('book_id','desc')->get();
        $data = json_decode($data,true);

        return view('user/search_book',["result_show"=>$data]);
    }
}
