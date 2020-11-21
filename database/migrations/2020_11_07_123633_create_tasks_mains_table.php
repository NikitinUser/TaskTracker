<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_mains', function (Blueprint $table) {
            $table->id();
            
            $table->dateTime('datatime_trash')->nullable();
            $table->string('task');
            $table->integer('userid');
            $table->integer('trash')->nullable();
            $table->dateTime('dt_send')->nullable();
            $table->integer('sending_status')->nullable();
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
        Schema::dropIfExists('tasks_mains');
    }
}
