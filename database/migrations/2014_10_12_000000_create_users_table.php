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
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('gender', ['man', 'woman'])->nullable();
            $table->string('full_name')->nullable();
            $table->string('mobile')->unique();
            $table->date('expire_at')->default('2025-01-01');
            $table->enum('status', ['ok', 'block'])->default('ok');
            $table->string('verify_code')->nullable();
            $table->string('cart_number')->nullable();
            $table->string('shaba')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->dateTime('last_send_sms_at')->nullable();
            $table->integer('gallery_id')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
