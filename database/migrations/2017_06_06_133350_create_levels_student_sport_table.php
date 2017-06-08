
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsStudentSportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_student_sport', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_sport_id')->unsigned();
            $table->foreign('student_sport_id')->references('id')->on('student_sport');
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels_student_sport');
    }
}