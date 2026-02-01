<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\VoteService;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function showPoll($id){
        $ips = DB::table('votes')->where('poll_id',$id)->get();
        return view('admin.poll',compact('id','ips'));
    }

    public function releaseIp(Request $r){
        VoteService::release($r->poll_id,$r->ip);
        return response()->json(['status'=>true]);
    }
}
