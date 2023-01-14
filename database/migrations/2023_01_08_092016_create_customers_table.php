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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('mobile');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('verify_code')->nullable();
            $table->dateTime('last_send_sms_at')->nullable();
            $table->foreignIdFor(\App\Models\Province::class);
            $table->foreignIdFor(\App\Models\City::class);
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
        Schema::dropIfExists('customers');
    }
};
