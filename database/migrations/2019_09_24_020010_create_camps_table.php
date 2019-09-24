<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('camps')) {
            Schema::create('camps', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('location')->nullable();
                $table->integer('entries')->nullable();
                $table->double('cost')->nullable();
                $table->timestamp('date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camps');
    }
}
