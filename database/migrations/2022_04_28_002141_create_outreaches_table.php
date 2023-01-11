<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutreachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outreaches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('contact_id');
            $table->bigInteger('owner_id');
            $table->string('owner_type', 20);
            $table->string('opportunities')->nullable();
            $table->boolean('payment_sent')->default(0);
            $table->date('io_date')->nullable();
            $table->string('notes', 75)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('description')->nullable();
            $table->boolean('manual')->default(false);
            $table->boolean('seen')->default(false);
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
        Schema::dropIfExists('outreaches');
    }
}
