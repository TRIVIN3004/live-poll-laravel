<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vote_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_id');
            $table->string('ip_address');
            $table->unsignedBigInteger('old_option_id')->nullable();
            $table->unsignedBigInteger('new_option_id')->nullable();
            $table->string('action'); // voted / released / revoted
            $table->timestamp('action_time');
        });
    }
    public function down(): void {
        Schema::dropIfExists('vote_history');
    }
};
