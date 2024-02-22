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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('url');
            $table->text('description')->nullable();
            $table->enum('domain_type', [
                'redirect',
                'website',
                'service',
            ]);
            $table->text('application_type')->nullable();
            $table->text('remote_system_user')->nullable();
            $table->text('remote_path')->nullable();
            $table->text('remote_php_path')->nullable();
            $table->text('ssh_private_key')->nullable();
            $table->foreignIdFor(\App\Models\Provider::class, 'dns_provider_id')
                ->constrained('providers')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
