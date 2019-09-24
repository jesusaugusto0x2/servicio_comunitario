<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('camps_payments')) {
            Schema::create('camps_payments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('reference')->nullable();
                $table->string('photo')->nullable();
                $table->timestamp('date')->nullable();
                $table->boolean('validated')->nullable()->default(false);

                $table->unsignedBigInteger('payment_method_id');
                $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');

                $table->unsignedBigInteger('camp_id');
                $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('camps_payments');
    }
}
