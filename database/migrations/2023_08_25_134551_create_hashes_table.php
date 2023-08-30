<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hashes', function (Blueprint $table) {
            $table->id();
            $table->char('hash', 32)->unique();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->date('valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hashes');
    }
};
