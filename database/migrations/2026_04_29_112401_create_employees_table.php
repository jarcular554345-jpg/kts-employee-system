<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('full_name');
            $table->string('position'); // Driver, Mechanic, Staff, Office Personnel
            $table->string('department');
            $table->string('contact_number');
            $table->text('address');
            $table->string('email')->unique();
            $table->date('date_hired');
            $table->decimal('salary', 10, 2);
            $table->enum('employment_status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};