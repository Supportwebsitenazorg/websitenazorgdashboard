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
        
    Schema::create('organization_user', function (Blueprint $table) {
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('organization_id')->constrained()->onDelete('cascade');

        $table->primary(['user_id', 'organization_id']);
    });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_user');
    }
};
