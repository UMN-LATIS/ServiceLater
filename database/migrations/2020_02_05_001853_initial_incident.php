<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitialIncident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('incident')->unique();
            $table->datetime('opened_at')->nullable();
            $table->datetime('closed_at')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('assignment_group_id')->unsigned();
            $table->string('service_offering_name')->nullable();
            $table->string('opened_by_name')->nullable();
            $table->string('opened_by_internet_id')->nullable();
            $table->text('work_notes_and_comments')->nullable();
            $table->text('close_notes')->nullable();
            $table->text('search')->nullable();
        });
        DB::statement('ALTER TABLE incidents ADD FULLTEXT fulltext_index (search)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
