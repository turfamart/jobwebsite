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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreign('category_id')->references('id')->on('catagories');
           $table->foreign('job_type_id')->references('id')->on('job_types');
           // $table->foreignId('category_id')->constrained()->onDelete('cascade');
         //  $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            $table->string('vacancy');
            $table->string('salary')->nullable();
            $table->string('location');
            $table->text('description');
            $table->text('benefits');
            $table->text('responsibility');
            $table->text('qualifications');
            $table->text('keywords');
            $table->string('experience');
            $table->string('company_name');
            $table->string('company_location');
            $table->string('company_website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
