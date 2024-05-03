<?php

use App\Models\Book;
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
        Schema::create('reading_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId(User::class)->constrained()->cascadeOnDelete();
            $table->foreignId(Book::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('start_page')->default(1);
            $table->unsignedInteger('end_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_intervals');
    }
};
