<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_interview_fields_to_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterviewFieldsToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->text('interview_script')->nullable();
            $table->text('interview_comments')->nullable();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('interview_script');
            $table->dropColumn('interview_comments');
        });
    }
}
