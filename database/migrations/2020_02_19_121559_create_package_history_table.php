<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_history', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 15,2)->default(0);
            $table->string('transaction_id');
            $table->integer('user_id');
            $table->boolean('status')->default(0);
            $table->integer('confirms_needed');
            $table->string('status_url');
            $table->string('package_type');
            $table->decimal('coins', 15,8)->default(0);
            $table->dateTime('approved_at');
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
        Schema::dropIfExists('package_history');
    }
}
