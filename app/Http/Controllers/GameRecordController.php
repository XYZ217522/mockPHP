<?php

namespace App\Http\Controllers;

use App\Http\FileHelperTrait;
use App\Http\Requests\GameRecordsUpdateRequest;
use App\Services\GameRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameRecordController extends Controller
{
    use FileHelperTrait;

    protected $gameRecordService;

    public function __construct(GameRecordService $gameRecordService)
    {
        $this->gameRecordService = $gameRecordService;
    }

    /***
     * @param Request $request
     * @return JsonResponse
     */
    public function getGameRecordList(Request $request): JsonResponse
    {
        $cachePath = config('cache.fileHelper.gameRecord.path');
        $json = $this->getDataByFile($cachePath, function () {
            return $this->gameRecordService->getGameRecordsByDB();
        });
        $result = config('response.success');
        $result['data'] = $json;

        return response()->json($result);
    }

    public function updateGameRecord(GameRecordsUpdateRequest $request)
    {
        $isApi = $request->is('api/*');

        // todo add
        $this->gameRecordService->saveGameRecordsByDB($request->all());

        // It will trigger send notification event if save a game record successful.
        // And receive the notification will send an e-mail to administrator.

        // todo reload and save cache
//        $cachePath = config('cache.fileHelper.gameRecord.path');
//        $data = $this->gameRecordService->getGameRecordsByDB();
//        $this->writeDataToFile($cachePath, $data);

        // todo clear file cache, the user visit home page will refresh page
        $this->clearFileCache(config('cache.fileHelper.gameRecord.path'));

        return $isApi ? response()->json(config('response.success')) : redirect('/');
    }

    public function deleteGameRecord(Request $request, $id)
    {
        $isApi = $request->is('api/*');
        $this->gameRecordService->deleteGameRecordById($id);
        $this->clearFileCache(config('cache.fileHelper.gameRecord.path'));
        return $isApi ? response()->json(config('response.success')) : redirect('/');
    }

}
