<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('UserId');
            $table->tinyInteger('Role')->comment('1: User, 2: Admin');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Email')->unique();
            $table->string('Password');
            $table->string('AuthToken')->nullable();
            $table->string('DeviceToken')->nullable();
            $table->tinyInteger('DeviceType')->default(0)->comment('1: IOS, 2: Android, 3: Website, 4: Admin');
            $table->tinyInteger('SocialType')->default(0)->comment('1: Normal, 2: Facebook, 3:Google');
            $table->string('SocialIdentifier')->nullable();
            $table->string('ProfilePicture')->nullable();
            $table->string('IsDelete')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
