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
        Schema::create('workspace_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('workspace_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Papel do usuário no workspace. Pode ser 'owner', 'admin', 'member', etc.
            $table->string('role')->default('member');

            // joined_at
            $table->timestamp('joined_at')->useCurrent();

            // Impede o mesmo usuario de entrar duas vezes no mesmo workspace
            $table->unique(['workspace_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspace_user');
    }
};
