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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('description')->nullable();
            $table->boolean('status')->default(false);

            $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();  // if user will be deleted all the articles related to user_id will be deleted

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete(); // if category deleted all the articles related to category will be deleted

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
