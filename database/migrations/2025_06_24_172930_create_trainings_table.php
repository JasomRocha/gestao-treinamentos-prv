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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('due_date');
            $table->text('description');
            $table->integer('qtd_student');
            $table->foreignId('type_training_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('instructor_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('client_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('financial_status_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('status_id')->constrained()->onDelete('CASCADE');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeignId('user_id');
            $table->dropForeignId('instructor_id');
            $table->dropForeignId('client_id');
            $table->dropForeignId('status_id');
            $table->dropForeignId('financial_status_id');
            $table->dropForeignId('type_training_id');
            $table->dropForeignIdF('training_id');
        });

        Schema::dropIfExists('trainings');
    }
};
