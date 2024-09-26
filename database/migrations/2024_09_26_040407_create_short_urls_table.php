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
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->string('original_url');
            $table->string('short_url')->unique(); 
            $table->integer('click_count')->default(0); 
            $table->unsignedBigInteger('created_by'); // Add created_by column
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('created_by')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_urls');
    }
};
