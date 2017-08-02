<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            // $table->string('slug')->unique();

            $table->string('language')->default('en');
            $table->string('author')->nullable();
            $table->string('author_email')->nullable();
            $table->string('copyright')->nullable();
            $table->boolean('is_explicit')->default(false);
            $table->json('categories')->nullable();

            $table->datetime('publish_at')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_complete')->default(false);

            // $table->belongsTo('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('podcasts');
    }
}
