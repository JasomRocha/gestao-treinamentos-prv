<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Training;
use App\Models\Resource;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_resource', function (Blueprint $table) {
            $table->id();
            $table->foreignId(Training::class)->references('id')->on('trainings')->onDelete('cascade');
            $table->foreignId(Resource::class)->references('id')->on('resources')->onDelete('cascade');
            $table->date('due_date');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_trainings', function (Blueprint $table) {
            $table->dropForeignIdFor(Training::class);
            $table->dropForeignIdFor(Resource::class);
        });
        Schema::dropIfExists('booking_resource');
    }
};
