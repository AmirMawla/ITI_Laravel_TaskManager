<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        $existingSlugs = [];

        Task::withTrashed()->orderBy('id')->get()->each(function (Task $task) use (&$existingSlugs) {
            $baseSlug = Str::slug($task->title);
            $slug = $baseSlug;
            $counter = 1;

            while (in_array($slug, $existingSlugs, true) || DB::table('tasks')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('tasks')
                ->where('id', $task->id)
                ->update(['slug' => $slug]);

            $existingSlugs[] = $slug;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};