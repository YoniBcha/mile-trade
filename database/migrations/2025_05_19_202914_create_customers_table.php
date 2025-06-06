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
            $table->string('image')->default('/default-images/avator.png');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('birth_date')->nullable();
            $table->text('about')->nullable();
            $table->string('phone')->unique();
            $table->string('bank_account_number')->unique();
            $table->softDeletes();
            $table->timestamps();
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
