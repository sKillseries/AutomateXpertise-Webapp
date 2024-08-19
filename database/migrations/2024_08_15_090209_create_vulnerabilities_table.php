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
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->id();
            $table->string('vuln_id')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('vuln_type');
            $table->string('severity');
            $table->text('impact');
            $table->string('attack_vector');
            $table->string('affected_environment');
            $table->text('proof_of_concept')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('status');
            $table->date('discovery_date');
            $table->date('notification_date')->nullable();
            $table->date('resolution_date')->nullable();
            $table->text('external_references')->nullable();
            $table->string('os');
            $table->string('port');
            $table->string('product');
            $table->string('version');
            $table->string('cpe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vulnerabilities');
    }
};
