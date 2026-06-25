<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $withinTransaction = false;
    public function up(): void
    {
       Schema::create('borrow_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            
            $table->enum('status', ['pending', 'borrowed', 'returned', 'cancelled'])->default('pending');
   
            $table->timestamp('borrowed_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('return_date')->nullable();
            

            $table->string('receipt_path')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
