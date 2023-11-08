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
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('height');
            $table->string('weight');
            $table->string('bp');
            $table->string('pr');
            $table->string('rr');
            $table->string('saturation');
            $table->string('lmp');
            $table->boolean('head_neck_scalp')->comment("1-normal, 0-abnormal");
            $table->string('head_neck_scalp_findings')->nullable();
            $table->boolean('eyes')->comment("1-normal, 0-abnormal");
            $table->string('eyes_findings')->nullable();
            $table->boolean('ears')->comment("1-normal, 0-abnormal");
            $table->string('ears_findings')->nullable();
            $table->boolean('nose_sinuses')->comment("1-normal, 0-abnormal");
            $table->string('nose_sinuses_findings')->nullable();
            $table->boolean('mouth')->comment("1-normal, 0-abnormal");
            $table->string('mouth_findings')->nullable();
            $table->boolean('neck_thyroid')->comment("1-normal, 0-abnormal");
            $table->string('neck_thyroid_findings')->nullable();
            $table->boolean('chest_breast_axilla')->comment("1-normal, 0-abnormal");
            $table->string('chest_breast_axilla_findings')->nullable();
            $table->boolean('heart')->comment("1-normal, 0-abnormal");
            $table->string('heart_findings')->nullable();
            $table->boolean('lungs')->comment("1-normal, 0-abnormal");
            $table->string('lungs_findings')->nullable();
            $table->boolean('abdomen')->comment("1-normal, 0-abnormal");
            $table->string('abdomen_findings')->nullable();
            $table->boolean('back')->comment("1-normal, 0-abnormal");
            $table->string('back_findings')->nullable();
            $table->boolean('anus')->comment("1-normal, 0-abnormal");
            $table->string('anus_findings')->nullable();
            $table->boolean('gut')->comment("1-normal, 0-abnormal");
            $table->string('gut_findings')->nullable();
            $table->boolean('inguinals')->comment("1-normal, 0-abnormal");
            $table->string('inguinals_findings')->nullable();
            $table->boolean('reflexes')->comment("1-normal, 0-abnormal");
            $table->string('reflexes_findings')->nullable();
            $table->boolean('extremities')->comment("1-normal, 0-abnormal");
            $table->string('extremities_findings')->nullable();
            $table->boolean('dental')->comment("1-normal, 0-abnormal");
            $table->string('dental_findings')->nullable();
            $table->string('right_eye');
            $table->string('left_eye');
            $table->string('withg_right_eye');
            $table->string('withg_left_eye');
            $table->string('ishihara');
            $table->string('colour_blind');
            $table->bigInteger('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_examinations');
    }
};
