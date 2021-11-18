<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable();
            $table->unsignedBigInteger('delivery_id')
                ->nullable();
            $table->unsignedMediumInteger('paid')
                ->default(0);
            $table->unsignedSmallInteger('status')
                ->default(1);
            $table->string('comment')
                ->nullable();
            $table->timestamp('delivered_at')
                ->nullable();
            $table->timestamp('deleted_at')
                ->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
