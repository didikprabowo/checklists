<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("object_domain", 50);
            $table->string("object_id", 11);
            $table->text("description");
            $table->boolean("is_completed")->default(0);
            $table->dateTime("due");
            $table->integer("urgency");
            $table->dateTime("completed_at")->nullable();
            $table->dateTime("last_update_by")->nullable();
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
        Schema::dropIfExists('checklists');
    }
}
