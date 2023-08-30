<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\City;
use App\Models\Type;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Type::class)->constrained()->onDelete('cascade');
            $table->text('short_info');
            $table->time('start_time');
            $table->time('close_time');
            $table->float('review', 1,1);
            $table->text('photos');
            $table->foreignIdFor(City::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('address');
            $table->text('history');
            $table->float('price', 8,2);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }

   

};
