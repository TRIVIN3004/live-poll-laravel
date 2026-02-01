<?php

namespace App\Core;

use Illuminate\Support\Facades\DB;

class VoteService
{
    public static function vote($pollId, $optionId)
    {
        $ip = request()->ip();

        // IP restriction
        $exists = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->exists();

        if ($exists) {
            return [
                'status' => false,
                'msg' => 'You already voted from this IP'
            ];
        }

        DB::table('votes')->insert([
            'poll_id' => $pollId,
            'option_id' => $optionId,
            'ip_address' => $ip,
            'created_at' => now()
        ]);

        DB::table('vote_history')->insert([
            'poll_id' => $pollId,
            'ip_address' => $ip,
            'old_option_id' => null,
            'new_option_id' => $optionId,
            'action' => 'voted',
            'action_time' => now()
        ]);

        return [
            'status' => true,
            'msg' => 'Vote submitted successfully'
        ];
    }

    public static function release($pollId, $ip)
    {
        $vote = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->first();

        if (!$vote) return;

        DB::table('vote_history')->insert([
            'poll_id' => $pollId,
            'ip_address' => $ip,
            'old_option_id' => $vote->option_id,
            'new_option_id' => null,
            'action' => 'released',
            'action_time' => now()
        ]);

        DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->delete();
    }
}
