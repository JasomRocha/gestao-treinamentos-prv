<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Training;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_training', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class)->references('id')->on('trainings')->onDelete('cascade');
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
        Schema::table('post_training', function (Blueprint $table) {
            $table->dropForeignIdFor(Training::class);
        });

        Schema::dropIfExists('post_training');
    }
};
