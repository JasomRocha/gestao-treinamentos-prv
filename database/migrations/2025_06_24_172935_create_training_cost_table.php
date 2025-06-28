<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Cost;
use App\Models\Training;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_cost', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class)->references('id')->on('trainings')->onDelete('cascade');
            $table->foreignId(Cost::class)->references('id')->on('costs')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->float('final_value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('training_costs', function (Blueprint $table) {
            $table->dropForeignIdFor(Training::class);
            $table->dropForeignIdFor(Cost::class);
        });
        Schema::dropIfExists('training_cost');
    }
};
