<?php

// database/migrations/2024_05_22_152644_add_gender_and_dob_to_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderAndDobToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('applications', 'dob')) {
                $table->date('dob')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('applications', 'dob')) {
                $table->dropColumn('dob');
            }
        });
    }
}
