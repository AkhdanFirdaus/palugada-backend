<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->text("deskripsi");
            $table->integer("kuota");
            $table->date("tanggal");
            $table->time("jam_mulai");
            $table->time("jam_selesai");
            $table->string("link");
            $table->foreignId('penyelenggara_id')->constrained('users');
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
        Schema::dropIfExists('webinars');
    }
}
