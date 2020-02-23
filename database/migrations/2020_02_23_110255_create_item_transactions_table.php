<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')
                  ->references('id')->on('branches')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                  ->references('id')->on('items')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('branch_item_id');
            $table->foreign('branch_item_id')
                  ->references('id')->on('branch_items')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->string('action');
            $table->bigInteger('stocks_count');
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
        Schema::dropIfExists('item_transactions');
    }
}
