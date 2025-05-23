<?php

use App\Models\Category;
use App\Models\Image;
use App\Models\Promotion;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 1000);
            $table->decimal('price', 10, 2);
            $table->foreignIdFor(Promotion::class)->nullable()->constrained();
            $table->foreignIdFor(Image::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
