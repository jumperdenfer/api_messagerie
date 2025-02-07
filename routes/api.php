<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AvatarController;

Route::get('/test',function(){
    echo "test";
});

Route::post('/message',[MessageController::class,'sendMessage']);
Route::get('/messages', [MessageController::class, 'getMessages']);
Route::post('/message/like',[MessageController::class,'addLike']);

Route::post('comment',[CommentController::class, 'sendComment']);
Route::get('comments',[CommentController::class,'getComments']);

Route::get('/avatar/{username}', [AvatarController::class, 'getAvatar']);