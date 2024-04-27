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
        Schema::create('species', function (Blueprint $table)
        {
            $table->id();
            $table->bigInteger('tsn')->unsigned();
            $table->char('clinic_id', 36);
            $table->string('familiar_name');
            $table->timestamps();

            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade')
                ->onUpdate('no action');
            $table->unique(['tsn', 'clinic_id']);
            $table->index('familiar_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('species');
    }
};
