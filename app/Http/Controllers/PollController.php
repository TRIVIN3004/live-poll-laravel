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
        // 🔐 Generate vote token (used for first vote)
        $voteToken = Str::uuid()->toString();
        session(['vote_token' => $voteToken]);

        return view('polls.view', compact('id', 'voteToken'));
    }

    public function vote(Request $request)
    {
        // 🔒 Validate token (prevents auto / replay)
        if (
            !$request->has('vote_token') ||
            $request->vote_token !== session('vote_token')
        ) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid vote request'
            ], 403);
        }

        // ✅ Process vote (same IP allowed – handled in VoteService)
        $result = VoteService::vote(
            $request->poll_id,
            $request->option_id
        );

        // 🔁 Generate NEW token so user can vote again
        $newToken = Str::uuid()->toString();
        session(['vote_token' => $newToken]);

        return response()->json([
            'status' => true,
            'msg' => $result['msg'],
            'vote_token' => $newToken   // send back to frontend
        ]);
    }
}
