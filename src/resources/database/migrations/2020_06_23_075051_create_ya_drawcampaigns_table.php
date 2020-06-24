<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYaDrawcampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ya_drawcampaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 500)->default(' ')->comment('title');
            $table->text('description', 20000)->comment('Description');
            $table->unsignedBigInteger('start_at')->default('0')->comment('start timestamp');
            $table->unsignedBigInteger('end_at')->default('0')->comment('end timestamp');

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
        Schema::dropIfExists('ya_drawcampaigns');
    }
}
