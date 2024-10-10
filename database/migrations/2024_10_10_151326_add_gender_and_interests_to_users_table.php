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
        Schema::table('users', function (Blueprint $table) {
            // Add gender as a string
            $table->string('gender')->nullable();

            // Add interests as a JSON or text column depending on your needs
            $table->text('interests')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove gender and interests columns
            $table->dropColumn('gender');
            $table->dropColumn('interests');
        });
    }
};