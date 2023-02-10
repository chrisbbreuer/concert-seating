<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class GenerateGuestAction extends Controller
{
    public function __invoke()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('generate:guests');

        return response()->json([
            'message' => 'Generated Successfully',
        ], 200);
    }
}
