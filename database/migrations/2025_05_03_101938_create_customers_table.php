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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_id')->unique(); // Used for public bill view
            $table->string('phone');
            $table->string('address');
            $table->unsignedBigInteger('package_id');
            $table->date('starting_date');
            $table->timestamps();
    
            // Optional: if you want to enforce the package foreign key
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
