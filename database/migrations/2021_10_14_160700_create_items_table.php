<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')
                ->nullable();
            $table->string('name');
            $table->longText('description');
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('price')->default(0);
            $table->unsignedSmallInteger('count')->default(0);
            $table->unsignedSmallInteger('order')->default(1);
            $table->unsignedSmallInteger('status')->default(1);
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
        Schema::dropIfExists('items');
    }
}
