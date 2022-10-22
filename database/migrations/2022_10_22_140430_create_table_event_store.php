<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTableEventStore extends Migration
{
    public function up(): void
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('event_name');
            $table->json('payload');
            $table->bigInteger('order')->autoIncrement();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_store');
    }
}
