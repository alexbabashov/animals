<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'active_animals', 
            function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->unsignedBigInteger("animal_id");
                $table->string('name')->unique();
                $table->float('size');
                $table->unsignedSmallInteger('age');

                $table->foreign('animal_id')->references('id')->on('animals');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_animals');
    }
}
