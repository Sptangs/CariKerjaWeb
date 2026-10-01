<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['job_seeker', 'company', 'admin'])
                ->default('job_seeker')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'job_seeker']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['job_seeker', 'company'])
                ->default('job_seeker')
                ->change();
        });
    }
};
