<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
// Tasks routes
Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TasksController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/{id}/restore', [TasksController::class, 'restore'])->name('tasks.restore');
Route::delete('/tasks/{id}/force-delete', [TasksController::class, 'forceDelete'])->name('tasks.forceDelete');

// Comments routes
Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});



// integrations
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('oauth.redirect');

Route::get('/auth/callback/{provider}', function ($provider) {
    $socialUser = Socialite::driver($provider)->user();
    
    
    $user = \App\Models\User::firstOrCreate(
        ['email' => $socialUser->getEmail()],
        [
            'name' => $socialUser->getName(),
            'password' => bcrypt('oauth-' . $provider . '-' . $socialUser->getId()),
        ]
    );
    
    
    Auth::login($user, remember: true);
    
    return redirect(route('tasks.index'));
})->name('oauth.callback');

