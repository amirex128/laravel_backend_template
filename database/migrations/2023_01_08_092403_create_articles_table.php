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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Gallery::class)->nullable();
            $table->foreignIdFor(\App\Models\Shop::class);
            $table->timestamps();
        });

        Schema::create('article_article_category', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Article::class);
            $table->foreignIdFor(\App\Models\ArticleCategory::class);
        });

        Schema::create('commentables', function (Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('commentable_id');
            $table->string('commentable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_article_category');
        Schema::dropIfExists('commentables');
    }
};
