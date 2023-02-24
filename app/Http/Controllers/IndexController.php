<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    public function __invoke()
    {
        $request = Request::create('/api/get-game-records');

        $statusArr = ['statusCode' => 1];

        if (empty($response = Route::dispatch($request))) {
            return view('error.page500', $statusArr);
        }

        if (!$response instanceof JsonResponse) {
            $statusArr['statusCode'] = 2;
            return view('error.page500', $statusArr);
        }

        if (empty($json = json_decode($response->content(), true)) || empty($json['data'])) {
            $statusArr['statusCode'] = 3;
            return view('error.page500', $statusArr);
        }

        $pageParam['gameRecords'] = $json['data'];
//        return view('home', $pageParam);
        return view('record-list', $pageParam);
    }
}
