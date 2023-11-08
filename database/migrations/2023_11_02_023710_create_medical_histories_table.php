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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->boolean('allergy')->comment("1-yes, 0-no");
            $table->boolean('amoebiasis')->comment("1-yes, 0-no");
            $table->boolean('anemia')->comment("1-yes, 0-no");
            $table->boolean('asthma')->comment("1-yes, 0-no");
            $table->boolean('cancer')->comment("1-yes, 0-no");
            $table->boolean('chronic')->comment("1-yes, 0-no");
            $table->boolean('diabetes')->comment("1-yes, 0-no");
            $table->boolean('dysmenorrhea')->comment("1-yes, 0-no");
            $table->boolean('fainting')->comment("1-yes, 0-no");
            $table->boolean('deafness')->comment("1-yes, 0-no");
            $table->boolean('endocrine')->comment("1-yes, 0-no");
            $table->boolean('frequent_headache')->comment("1-yes, 0-no");
            $table->boolean('neck_injury')->comment("1-yes, 0-no");
            $table->boolean('heart_disease')->comment("1-yes, 0-no");
            $table->boolean('hernias')->comment("1-yes, 0-no");
            $table->boolean('highblood_pressure')->comment("1-yes, 0-no");
            $table->boolean('insomnia')->comment("1-yes, 0-no");
            $table->boolean('kidney_disease')->comment("1-yes, 0-no");
            $table->boolean('skeletal_disorder')->comment("1-yes, 0-no");
            $table->boolean('nervous_breakdown')->comment("1-yes, 0-no");
            $table->boolean('nose_trouble')->comment("1-yes, 0-no");
            $table->boolean('peptic_ulcer')->comment("1-yes, 0-no");
            $table->boolean('tuberculosis')->comment("1-yes, 0-no");
            $table->boolean('hospitalization')->comment("1-yes, 0-no");
            $table->boolean('surgical_operation')->comment("1-yes, 0-no");
            $table->bigInteger('form_id')->unsigned();
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
