<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampsPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('camps_photos')) {
            Schema::create('camps_photos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('url')->nullable();
                $table->unsignedBigInteger('camp_id');
                $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
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
        Schema::dropIfExists('camps_photos');
    }
}
