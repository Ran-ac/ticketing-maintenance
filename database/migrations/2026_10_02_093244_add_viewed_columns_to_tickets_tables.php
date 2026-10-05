<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_assigned', function (Blueprint $table) {
            $table->timestamp('viewed_at')->nullable();
        });

        Schema::table('ticket', function (Blueprint $table) {
            $table->timestamp('approval_viewed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ticket_assigned', function (Blueprint $table) {
            $table->dropColumn('viewed_at');
        });

        Schema::table('ticket', function (Blueprint $table) {
            $table->dropColumn('approval_viewed_at');
        });
    }
};