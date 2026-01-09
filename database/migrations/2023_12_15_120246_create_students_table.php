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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('phone');
            $table->string('email');
            $table->string('mobile');
            $table->string('city');
            $table->string('fathername')->nullable();
            $table->date('joiningdate')->default(now());
            $table->date('DOB');
            $table->string('gender');
            $table->text('address');
            $table->string('pincode');
            $table->string('community')->nullable();
            $table->string('qualification');
            $table->string('board');
            $table->string('passing_year');
            $table->float('percentage');
            $table->text('subjects')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
