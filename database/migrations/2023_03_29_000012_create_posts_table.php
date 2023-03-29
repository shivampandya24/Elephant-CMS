<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('detail')->nullable();
            $table->string('status');
            $table->string('visibility');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
