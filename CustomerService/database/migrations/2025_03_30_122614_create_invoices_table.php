<?php

use App\Models\Order;
use App\Models\User;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('adreess', 255);
            $table->string('post_code', 255);
            $table->string('city', 255);
            $table->string('nip', 255)->nullable();
            $table->string('invoice_number', 255)->unique();
            $table->decimal('amount', 10, 2);
            $table->$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
