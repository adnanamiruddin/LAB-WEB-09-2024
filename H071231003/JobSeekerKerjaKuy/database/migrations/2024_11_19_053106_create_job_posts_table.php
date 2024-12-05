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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('title')->notNull();
            $table->string('location')->notNull();
            $table->enum('job_type', ['full-time', 'part-time', 'freelance'])->notNull();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('description')->notNull();
            $table->text('requirements')->notNull();
            $table->decimal('salary',15,2)->nullable();
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->enum('payday', ['yearly','monthly', 'weekly', 'daily'])->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
