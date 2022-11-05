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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('kind_en');
            $table->string('kind_ar');
            $table->string('price');
            $table->string('description_en');
            $table->string('description_ar');
            $table->integer('totalrooms');
            $table->integer('currentrooms');
            $table->integer('orderrooms');
            $table->String('image_url')->nullable();
            $table->foreignId('living_id')->constrained();
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
        Schema::dropIfExists('rooms');
    }
};
