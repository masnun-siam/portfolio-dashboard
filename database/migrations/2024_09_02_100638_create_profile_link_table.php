<?php

use App\Models\Link;
use App\Models\Profile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Profile::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Link::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_link');
    }
};
