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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('total_sales')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->boolean('active')->default(true);
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->enum('block_status', ['block', 'ok'])->default('ok');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Shop::class);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('gallery_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Gallery::class);
            $table->foreignIdFor(\App\Models\Product::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('gallery_product');
    }
};
