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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->integer('count');
            $table->integer('value');
            $table->integer('percent');
            $table->boolean('status')->default(true);
            $table->enum('type', ['percent', 'amount']);
            $table->foreignIdFor(\App\Models\User::class);
            $table->timestamps();
        });

        Schema::create('discount_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Discount::class);
            $table->foreignIdFor(\App\Models\Product::class);
        });
        Schema::create('shop_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Discount::class);
            $table->foreignIdFor(\App\Models\Shop::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('discount_product');
        Schema::dropIfExists('shop_product');
    }
};
