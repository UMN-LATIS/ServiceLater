<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssignmentGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
        });

        Schema::table("incidents", function (Blueprint $table) {
            $table->foreign("assignment_group_id")
                ->references("id")
                ->on("assignment_groups");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("incidents", function (Blueprint $table) {
            $table->dropForeign("incidents_assignment_group_id_foreign");
        });
        Schema::dropIfExists('assignment_groups');
    }
}
