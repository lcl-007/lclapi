<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('用户id');
            $table->string('name')->comment('收货人');
            $table->integer('city_id')->comment('收货地址city表中的id');
            $table->string('address')->comment('地址描述');
            $table->string('phone')->comment('手机号');
            $table->tinyInteger('id_default')->default(0)->comment('是否是默认地址:0不是默认，1是默认');
            $table->index('user_id');
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
        Schema::dropIfExists('addresses');
    }
}
