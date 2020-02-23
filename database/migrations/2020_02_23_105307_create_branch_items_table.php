<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')
                  ->references('id')->on('branches')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                  ->references('id')->on('items')
                  ->onDelete('cascade');
            $table->longText('information');
            $table->bigInteger('remaining_stocks')->default(0);
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
        Schema::dropIfExists('branch_items');
    }
}
