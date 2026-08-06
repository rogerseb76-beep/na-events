<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table
                ->string('registration_status', 20)
                ->default('confirmed')
                ->after('club');

            $table
                ->index(
                    ['event_session_id', 'registration_status'],
                    'participants_session_registration_status_index'
                );
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex(
                'participants_session_registration_status_index'
            );

            $table->dropColumn('registration_status');
        });
    }
};
