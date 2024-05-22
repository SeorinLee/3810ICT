<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->text('reason')->nullable();
            $table->text('experience')->nullable();
            $table->string('position_title')->nullable();
            $table->string('video_link')->nullable();
            $table->text('document_link')->nullable();
            $table->text('quiz_result')->nullable();
            $table->text('workshop_info')->nullable();
            $table->text('workshop_result')->nullable();
            $table->text('interview_notes')->nullable();
            $table->text('interview_result')->nullable();
            $table->text('unique_job_plan')->nullable();
            $table->text('unique_job_plan_comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
