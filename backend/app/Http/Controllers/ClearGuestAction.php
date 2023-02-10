<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ClearGuestAction extends Controller
{
    public function __invoke()
    {
        Artisan::call('migrate:fresh');

        return response()->json([
            'message' => 'Cleared Successfully',
        ], 200);
    }
}
