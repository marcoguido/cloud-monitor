<?php

use App\Models\Cluster;
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
        Schema::create('vpcs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('operating_system');
            $table->text('operating_system_release');
            $table->text('hostname')->nullable();
            $table->text('public_ip')->nullable();
            $table->text('private_ip')->nullable();
            $table->boolean('is_ssh_enabled')->default(true);
            $table->unsignedInteger('ssh_port')->default(22);
            $table->text('management_url')->nullable();
            $table->text('password_manager_credentials_url')->nullable();
            $table->foreignIdFor(Cluster::class)
                ->constrained()
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
        Schema::dropIfExists('vpcs');
    }
};
