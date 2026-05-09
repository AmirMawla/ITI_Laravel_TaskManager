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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->boolean("completed");
            $table->date("due_date");
            $table->string("priority");
            $table->string("color");
            $table->enum('status', ['To Do', 'In Progress', 'Completed'])
                  ->default('To Do');
            $table->timestamps();
            $table->unsignedBigInteger("creator_id")->NULLABLE;
            $table->unsignedBigInteger("assigned_id");
            
            
             $table->foreign('creator_id')->references('id')->on('users');
             $table->foreign('assigned_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
