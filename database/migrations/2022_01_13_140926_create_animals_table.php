<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'animals',
            function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('kind')->unique();
                $table->unsignedSmallInteger('size_max');
                $table->unsignedSmallInteger('age_max');
                $table->float('grow_factor');
                $table->string('avatar')->unique();
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
        Schema::dropIfExists('animals');
    }
}
