<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('CASCADE');
            $table->foreignId('purchase_id')
                ->references('id')
                ->on('purchases')
                ->onDelete('CASCADE');
            $table->unsignedSmallInteger('count')
                ->default(1);
            $table->unsignedSmallInteger('status')
                ->default(1);
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
        Schema::dropIfExists('purchase_item');
    }
}
