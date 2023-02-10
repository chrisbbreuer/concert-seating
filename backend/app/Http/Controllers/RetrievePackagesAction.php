<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class RetrievePackagesAction extends Controller
{
    public function __invoke()
    {
        $cachedResponse = Cache::get('packages');

        if ($cachedResponse) {
            return $cachedResponse;
        }

        $response = [
            [
                'id' => 1,
                'name' => 'package_1',
            ],
            [
                'id' => 2,
                'name' => 'package_2',
            ],
            [
                'id' => 3,
                'name' => 'package_3',
            ],
            [
                'id' => 4,
                'name' => 'package_4',
            ],
            [
                'id' => 5,
                'name' => 'package_5',
            ],
        ];

        Cache::put('packages', $response, 60);

        return $response;
    }
}
