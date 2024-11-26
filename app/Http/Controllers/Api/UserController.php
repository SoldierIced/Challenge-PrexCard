<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function myUser(Request $request)
    {
        try {
            $user = $request->user();
            $user->gifs = $user->with("gifs")->get();

            return $this->sendResponse($user);
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 500);
        }
    }
}
