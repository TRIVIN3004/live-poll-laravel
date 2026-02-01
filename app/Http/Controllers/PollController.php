<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\VoteService;
use Illuminate\Support\Str;

class PollController extends Controller
{
    public function index()
    {
        return view('polls.index');
    }

    public function show($id)
    {
        // 🔐 Generate ONE-TIME vote token
        $voteToken = Str::uuid()->toString();
        session(['vote_token' => $voteToken]);

        return view('polls.view', compact('id', 'voteToken'));
    }

    public function vote(Request $request)
    {
        // 🔒 BLOCK auto / replayed POST
        if (
            !$request->has('vote_token') ||
            $request->vote_token !== session('vote_token')
        ) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid or replayed vote request'
            ], 403);
        }

        // 🔥 Consume token (ONE TIME ONLY)
        session()->forget('vote_token');

        return response()->json(
            VoteService::vote(
                $request->poll_id,
                $request->option_id
            )
        );
    }
}
