<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->uuid('order_guid')->unique();
            $table->string('name', 250);
            $table->string('email', 250)->nullable();
            $table->string('phone_number', 20);
            $table->string('zip_code', 10);
            $table->unsignedInteger('amount');
            $table->string('currency', 10);
            $table->string('account_no', 100);
            $table->string('client_ip', 100)->nullable();
            $table->string('stripe_token', 150)->nullable();
            $table->string('stripe_transaction_id', 150)->nullable();
            $table->json('stripe_payload')->nullable();
            $table->enum('order_status',['Pending', 'Success', 'Failed'])->default('Pending');
            $table->unsignedBigInteger('reprocessed_by')->nullable();
            $table->foreign('reprocessed_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
