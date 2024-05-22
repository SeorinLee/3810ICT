<?php
// database/migrations/2024_05_22_164253_add_position_title_and_experience_to_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionTitleAndExperienceToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'position_title')) {
                $table->string('position_title')->nullable();
            }
            if (!Schema::hasColumn('applications', 'experience')) {
                $table->text('experience')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'position_title')) {
                $table->dropColumn('position_title');
            }
            if (Schema::hasColumn('applications', 'experience')) {
                $table->dropColumn('experience');
            }
        });
    }
}
