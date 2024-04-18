<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Publish;
use App\Models\Subject;
use App\Models\Classs;
use App\Models\Teacher;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('name_course');
            $table->string('description')->nullable();
            $table->double('cost_course');
            $table->date('start_date');
            $table->date('finish_date');
            $table->time('start_time');
            $table->time('finish_time');
            $table->string('year');
            $table->foreignIdFor(Publish::class,'publish_id');
            $table->foreignIdFor(Subject::class,'subject_id');
            $table->foreignIdFor(Classs::class,'class_id');
            $table->foreignIdFor(Teacher::class,'teacher_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
