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
       Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('category'); 
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('total_stock')->default(0);
            $table->integer('available_stock')->default(0);
            $table->integer('rating')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('summary');
        });
    }
};
