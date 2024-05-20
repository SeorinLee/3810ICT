<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_quiz_result_to_applications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizResultToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('quiz_passed')->default(false);
            $table->json('quiz_answers')->nullable();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('quiz_passed');
            $table->dropColumn('quiz_answers');
        });
    }
}
