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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('business_unit_name');
            $table->date('start_date');
            $table->integer('duration'); 
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('lead_developer_id');
            $table->unsignedBigInteger('pic_id');
            $table->enum('development_methodology', ['Agile Development', 'DevOps Deployment', 'Waterfall Development', 'Rapid Application Development'])->nullable();
            $table->enum('system_platform', ['Web-based App', 'Mobile App', 'Stand-alone App'])->nullable();
            $table->enum('deployment_type', ['Cloud', 'On-premises'])->nullable();
            $table->enum('status', ['Ahead of Schedule', 'On Schedule', 'Delayed', 'Completed'])->nullable();
            $table->date('last_report')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        
            // Foreign key relationship
            $table->foreign('lead_developer_id')->references('id')->on('users');
            $table->foreign('pic_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
