<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default(1);
            $table->foreignIdFor(\App\Models\Order::class);
            $table->foreignIdFor(\App\Models\Product::class);
            $table->foreignIdFor(\App\Models\Option::class)->nullable();
            $table->integer('quantity')->comment('موجودس محصول');
            $table->integer('raw_price')->comment('قیمت اصلی محصول');
            $table->integer('raw_price_option')->comment('قیمت اصلی اپشن');
            $table->integer('raw_price_count')->comment('قیمت اصلی محصول با توجه به تعداد');
            $table->integer('raw_price_option_count')->comment('قیمت اصلی اپشن با توجه به تعداد');
            $table->integer('amount')->comment('قیمت تخفیف');
            $table->integer('percent')->comment('درصد تخفیف');
            $table->integer('off_price')->comment('قیمت تخفیف داده شده');
            $table->integer('off_price_option')->comment('قیمت تخفیف داده شده اپشن');
            $table->integer('new_price')->comment('قیمت به همراه تعداد و تخفیف');
            $table->integer('new_price_option')->comment('قیمت به همراه تعداد و تخفیف اپشن');
            $table->integer('final_raw_price')->comment('قیمت نهایی بدون تخفیف');
            $table->integer('final_price')->comment('قیمت نهایی با تخفیف');
            $table->boolean('has_option')->comment('آیا این محصول اپشن دارد؟');
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
        Schema::dropIfExists('order_items');
    }
};
