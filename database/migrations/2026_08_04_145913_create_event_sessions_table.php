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
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('title');

            $table->time('start_time');
            $table->time('end_time');

            $table->unsignedTinyInteger('capacity')->default(12);
            $table->unsignedTinyInteger('display_order')->default(1);
        $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sessions');
    }
};