<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentPagePostPivotTable extends Migration
{
    public function up()
    {
        Schema::create('content_page_post', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id', 'post_id_fk_8255146')->references('id')->on('posts')->onDelete('cascade');
            $table->unsignedBigInteger('content_page_id');
            $table->foreign('content_page_id', 'content_page_id_fk_8255146')->references('id')->on('content_pages')->onDelete('cascade');
        });
    }
}
