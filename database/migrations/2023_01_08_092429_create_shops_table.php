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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('social_address')->nullable();
            $table->string('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('instagram_id')->nullable();
            $table->string('whatsapp_id')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->integer('send_price')->default(0);
            $table->enum('type', ['instagram', 'telegram', 'website'])->default('instagram');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Gallery::class)->nullable();
            $table->foreignIdFor(\App\Models\Theme::class)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('shops');
    }
};
