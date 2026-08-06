<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table
                ->string('status', 20)
                ->default('draft')
                ->after('location');

            $table->index(
                ['status', 'event_date'],
                'events_status_event_date_index'
            );
        });

        DB::table('events')
            ->where('is_active', true)
            ->update(['status' => 'published']);

        DB::table('events')
            ->where('is_active', false)
            ->update(['status' => 'draft']);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(
                'events_status_event_date_index'
            );

            $table->dropColumn('status');
        });
    }
};
