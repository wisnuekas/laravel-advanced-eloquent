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
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->string('sex_preference')->nullable();
            $table->unsignedInteger('max_fee')->nullable();
            $table->unsignedInteger('min_fee')->nullable();
            $table->string('payment_method');
            $table->unsignedInteger('total')->nullable();
            $table->string('canceled_reason')->nullable();
            $table->boolean('custom')->default(0);
            $table->foreignId('category_id');
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('mitra_id')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
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
