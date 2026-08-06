<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('app_settings')->insert([
            [
                'key' => 'registration_state',
                'value' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_message_open',
                'value' => 'Les inscriptions sont ouvertes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_message_live',
                'value' => 'La journée est en cours. Les réservations sont désormais closes. Merci de vous présenter à l’accueil.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_message_closed',
                'value' => 'Les inscriptions sont actuellement fermées.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
