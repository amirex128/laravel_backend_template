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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort');
            $table->string('description')->nullable();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Shop::class);
            $table->timestamps();
        });
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Category::class);
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_product');
    }
};
