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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doc_id')->unsigned();
            $table->bigInteger('pat_id')->unsigned();
            $table->date('date');
            $table->timestamps();
            $table->foreign('doc_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('pat_id')->references('id')->on('patients')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
