<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id');
            $table->string('owner_type', 20);
            $table->enum('type', ['Brand', 'Creator'])->default('Brand');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('website');
            $table->string('domain');
            $table->string('logo')->nullable();
            $table->integer('network_id')->nullable();
            $table->string('network')->nullable();
            $table->string('network_link')->nullable();
            $table->string('tags')->nullable();
            $table->float('commission')->nullable();
            $table->string('commission_type', 1)->nullable();
            $table->string('commission_unit')->nullable();
            $table->string('exclusive_deal')->nullable();
            $table->boolean('offers')->default(false);
            $table->boolean('posts')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
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
        Schema::dropIfExists('contacts');
    }
}
