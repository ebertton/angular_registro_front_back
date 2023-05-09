<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_knowledges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id')->nullable();;
            $table->unsignedBigInteger('knowledges_id')->nullable();;
            $table->timestamps();
            $table->foreign('employees_id')
                ->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('knowledges_id')
                ->references('id')->on('knowledges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_knowledges');
    }
};
