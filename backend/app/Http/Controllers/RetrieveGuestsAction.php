<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class RetrieveGuestsAction extends Controller
{
    public function __invoke(Request $request)
    {
        $guest = Guest::create([
            'name' => $request->name,
            'companions' => $request->companions,
            'package_id' => $request->package_id,
        ]);

        return response()->json([
            'id' => $guest->id,
            'message' => 'Reserved Successfully',
        ], 200);
    }
}
