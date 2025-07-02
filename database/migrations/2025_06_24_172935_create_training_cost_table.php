<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->foreignId('cost_id')->references('id')->on('costs')->onDelete('cascade');
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
            $table->dropForeignId('training_id');
            $table->dropForeignId('cost_id');
        });
        Schema::dropIfExists('training_costs');
    }
};
