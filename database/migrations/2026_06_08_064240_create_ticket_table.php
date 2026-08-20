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
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_type');
            $table->string('type_of_concern')->nullable();
            $table->unsignedBigInteger('clinics_id')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('Pending');
            $table->string('type_equipment_or_machine')->nullable();
            $table->string('equipment_or_machine_brand')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('concern_description')->nullable();
             $table->string('reported_by')->nullable();
             $table->text('file')->nullable();

            // assignment
            $table->unsignedBigInteger('assigned_by')->nullable();

            $table->foreign('assigned_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
