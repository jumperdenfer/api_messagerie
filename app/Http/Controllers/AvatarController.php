<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function getAvatar($username)
    {
        $avatarUrl = "https://api.dicebear.com/9.x/identicon/svg?see=" . urlencode($username);
        return response()->json(['avatar'=>$avatarUrl]);
    }
}
