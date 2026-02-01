<?php

namespace App\Core;

use Illuminate\Support\Facades\DB;

class VoteService
{
    public static function vote($pollId, $optionId)
    {
        $ip = request()->ip();

        // 🔍 Check if this IP already voted for this poll
        $oldVote = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->first();

        // 🧾 If old vote exists, store history & remove it
        if ($oldVote) {
            DB::table('vote_history')->insert([
                'poll_id' => $pollId,
                'ip_address' => $ip,
                'old_option_id' => $oldVote->option_id,
                'new_option_id' => $optionId,
                'action' => 'revoted',
                'action_time' => now()
            ]);

            DB::table('votes')
                ->where('poll_id', $pollId)
                ->where('ip_address', $ip)
                ->delete();
        } else {
            // 🧾 First-time vote history
            DB::table('vote_history')->insert([
                'poll_id' => $pollId,
                'ip_address' => $ip,
                'old_option_id' => null,
                'new_option_id' => $optionId,
                'action' => 'voted',
                'action_time' => now()
            ]);
        }

        // ✅ Insert new vote
        DB::table('votes')->insert([
            'poll_id' => $pollId,
            'option_id' => $optionId,
            'ip_address' => $ip,
            'created_at' => now()
        ]);

        return [
            'status' => true,
            'msg' => $oldVote
                ? 'Your vote has been updated successfully'
                : 'Vote submitted successfully'
        ];
    }

    public static function release($pollId, $ip)
    {
        $vote = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->first();

        if (!$vote) return;

        // 🧾 Store release history
        DB::table('vote_history')->insert([
            'poll_id' => $pollId,
            'ip_address' => $ip,
            'old_option_id' => $vote->option_id,
            'new_option_id' => null,
            'action' => 'released',
            'action_time' => now()
        ]);

        // ❌ Remove vote
        DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->delete();
    }
}
