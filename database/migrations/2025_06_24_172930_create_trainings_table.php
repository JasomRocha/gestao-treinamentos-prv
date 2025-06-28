<?php

use App\Models\Client;
use App\Models\FinancialStatus;
use App\Models\Instructor;
use App\Models\PostTraining;
use App\Models\Status;
use App\Models\TypeTraining;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
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
            $table->foreignIdFor(TypeTraining::class)->references('id')->on('type_trainings')->onDelete('CASCADE');
            $table->foreignIdFor(User::class)->references('id')->on('users')->onDelete('CASCADE');
            $table->foreignIdFor(Instructor::class)->references('id')->on('instructors')->onDelete('CASCADE');
            $table->foreignIdFor(Client::class)->references('id')->on('clients')->onDelete('CASCADE');
            $table->foreignIdFor(FinancialStatus::class)->references('id')->on('financial_status')->onDelete('CASCADE');
            $table->foreignIdFor(Status::class)->references('id')->on('status')->onDelete('CASCADE');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeignIdFor(User::class);
            $table->dropForeignIdFor(Instructor::class);
            $table->dropForeignIdFor(Client::class);
            $table->dropForeignIdFor(Status::class);
            $table->dropForeignIdFor(FinancialStatus::class);
            $table->dropForeignIdFor(TypeTraining::class);
            $table->dropForeignIdFor(PostTraining::class);
        });

        Schema::dropIfExists('trainings');
    }
};
