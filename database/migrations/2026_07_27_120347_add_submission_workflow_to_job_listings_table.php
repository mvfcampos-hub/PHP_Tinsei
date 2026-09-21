<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('status')->default('approved')->after('is_active'); // pending, approved, rejected
            $table->string('submitter_name')->nullable()->after('status');
            $table->string('submitter_email')->nullable()->after('submitter_name');
            $table->string('submitter_phone')->nullable()->after('submitter_email');
            $table->string('removal_token', 64)->nullable()->unique()->after('submitter_phone');
            $table->timestamp('removal_requested_at')->nullable()->after('removal_token');

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn([
                'status',
                'submitter_name',
                'submitter_email',
                'submitter_phone',
                'removal_token',
                'removal_requested_at',
            ]);
        });
    }
};
