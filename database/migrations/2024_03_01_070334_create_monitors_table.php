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
        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->text('slug');
            $table->unsignedInteger('update_frequency')->default(5);
            $table->boolean('ssl_check');
            $table->boolean('ping_check')->comment('Whether to perform healthcheck verifications');
            $table->text('ping_endpoint')
                ->nullable()
                ->comment('The url to be used to perform healthcheck verifications. If null, domain base URL will be used');
            $table->foreignIdFor(\App\Models\Domain::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamp('last_ssl_check')->nullable();
            $table->timestamp('last_ping_check')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
