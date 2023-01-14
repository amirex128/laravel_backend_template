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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip')->nullable();
            $table->integer('total_product_price');
            $table->integer('total_discount_price');
            $table->integer('total_tax_price');
            $table->integer('total_product_discount_price');
            $table->integer('total_final_price');
            $table->integer('send_price')->default(0);
            $table->string('status');
            $table->string('description')->nullable();
            $table->string('package_size')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('courier')->nullable();
            $table->dateTime('last_update_status_at');
            $table->integer('weight')->nullable();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Shop::class);
            $table->foreignIdFor(\App\Models\Customer::class);
            $table->foreignIdFor(\App\Models\Discount::class);
            $table->foreignIdFor(\App\Models\Address::class);
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
};
