<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('email', 64)->unique();
            $table->string('shop_name', 64)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('owner')->default(false);
            $table->string('photo_path', 100)->nullable();
            $table->string('card_brand', 32)->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('shop_domain')->nullable();
            $table->boolean('is_enabled')->nullable();
            $table->string('billing_plan')->nullable();
            $table->timestamp('trial_starts_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
