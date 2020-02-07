<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users",function(Blueprint $table) {
            $table->boolean("admin")->default(false);
        });

        Schema::create("assignment_group_user",function(Blueprint $table) {
            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
            $table->integer("assignment_group_id")->unsigned()->nullable();
            $table->foreign('assignment_group_id')->references('id')
            ->on('assignment_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users",function(Blueprint $table) {
            $table->dropColumn("global_admin");
        });
        Schema::dropIfExists('assignment_group_user');
    }
}
