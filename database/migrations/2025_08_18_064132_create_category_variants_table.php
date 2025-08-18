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
        Schema::create('category_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
            $table->unsignedBigInteger('variant_id')->foreign('variant_id')
                ->references('id')->on('variants')
                ->onDelete('cascade');
            
            $table->string('title')->nullable();
            $table->boolean('is_publish')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_variants');
    }
};
