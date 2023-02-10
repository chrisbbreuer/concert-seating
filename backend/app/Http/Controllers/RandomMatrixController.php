<?php

namespace App\Http\Controllers;

use App\Models\Guest;

class RandomMatrixController extends Controller
{
    /**
     * This method retrieves all guests from the database in a random order and passes them to the seatGuests method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return $this->seatGuests(Guest::inRandomOrder()->get()->toArray());
    }

    /**
     * This method takes an array of guests and seats them in a 10x10 matrix.
     *
     * @param  array  $mockData
     * @return array
     */
    public function seatGuests($mockData)
    {
        $matrix = [];
        $seats = array_fill(0, 100, 'x');
        $guests = $mockData;
        $insertsCounter = 0;
        $guestStartCounter = 0;

        foreach ($guests as $guest) {
            $foundExcess = false;
            $foundCounter = 0;
            $jumpCounter = 0;
            $key = 0;

            $key = $insertsCounter;

            if ($key === 100) {
                break;
            }

            while ($seats[$insertsCounter] !== 'x') {
                $insertsCounter++;

                $key = $insertsCounter;

                if ($key === 100) {
                    break 2;
                }
            }

            $seats[$insertsCounter] = [
                'id' => $guest['id'],
                'name' => $guest['name'],
                'package_id' => $guest['package_id'],
                'companion_slot' => 0,
            ];

            $guestStartCounter = $insertsCounter;

            for ($i = 1; $i <= $guest['companions']; $i++) {
                if (! $foundExcess) {
                    $insertsCounter++;
                }

                $key = $insertsCounter;

                if ($key === 100) {
                    break 2;
                }

                while ($seats[$insertsCounter] !== 'x') {
                    $insertsCounter++;

                    $key = $insertsCounter;

                    if ($key === 100) {
                        break 3;
                    }
                }

                if ($insertsCounter % 10 === 0 || $foundExcess) {
                    if ($guestStartCounter % 10 === 9) {
                        $jumpCounter++;

                        $key = $guestStartCounter + (10 * $jumpCounter);

                        if ($key === 100) {
                            break 2;
                        }

                        $seats[$key] = [
                            'id' => $guest['id'],
                            'name' => $guest['name'],
                            'package_id' => $guest['package_id'],
                            'companion_slot' => $i,
                        ];

                        $foundExcess = true;
                    } else {
                        $key = $guestStartCounter + 10 + $foundCounter;

                        if ($key === 100) {
                            break 2;
                        }

                        $seats[$key] = [
                            'id' => $guest['id'],
                            'name' => $guest['name'],
                            'package_id' => $guest['package_id'],
                            'companion_slot' => $i,
                        ];

                        $foundCounter++;
                        $foundExcess = true;
                    }
                } else {
                    $key = $insertsCounter;

                    if ($key === 100) {
                        break 2;
                    }

                    $seats[$key] = [
                        'id' => $guest['id'],
                        'name' => $guest['name'],
                        'package_id' => $guest['package_id'],
                        'companion_slot' => $i,
                    ];
                }
            }

            if (! $foundExcess) {
                $insertsCounter++;
            }
        }

        for ($i = 0; $i < 100; $i++) {
            $row = floor($i / 10);
            $col = $i % 10;
            $matrix[$row][$col] = $seats[$i];
        }

        return $matrix;
    }
}
