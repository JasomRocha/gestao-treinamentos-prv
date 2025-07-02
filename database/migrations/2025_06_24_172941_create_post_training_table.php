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
        Schema::create('post_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->string('event');
            $table->string('status')->default('pendente'); // pendente, concluido, etc.
            $table->date('conclusion_date')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_trainings', function (Blueprint $table) {
            $table->dropForeignId('training_id');
        });

        Schema::dropIfExists('post_training');
    }
};
