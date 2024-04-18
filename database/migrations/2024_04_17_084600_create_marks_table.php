<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Student;
use App\Models\Subject;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();

            $table->integer('ponus')->default(0);
            $table->integer('homework')->default(0);
            $table->integer('oral')->default(0);
            $table->integer('test1')->default(0);
            $table->integer('test2')->default(0);
            $table->integer('exam_med')->default(0);
            $table->integer('exam_final')->default(0);
            $table->boolean('state')->default(0);
            $table->foreignIdFor(Student::class,'student_id');
            $table->foreignIdFor(Subject::class,'subject_id');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
