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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('profile_picture')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->string('password');
            $table->string('address');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
};
