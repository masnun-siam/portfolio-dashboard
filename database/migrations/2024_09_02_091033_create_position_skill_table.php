<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('position_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('skill_id')->constrained('skills');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_skill');
    }
};
