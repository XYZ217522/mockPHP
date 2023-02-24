<?php

namespace App\Services;

use App\Jobs\GameRecordsUpDateJob;
use App\Models\GameRecords;

class GameRecordService
{
    const GAME_FROM_DATE = "2023-01-01";

    private $gameRecords;

    public function __construct(GameRecords $gameRecords)
    {
        $this->gameRecords = $gameRecords;
    }

    public function getGameRecordsByDB(): array
    {
        return $this->gameRecords
            ::whereBetween('create_date', [self::GAME_FROM_DATE, Date('Y-m-d 23:59:59')])
            ->get()
            ->toArray();
    }

    public function saveGameRecordsByDB(array $params): bool
    {
        $gameRecords = new GameRecords();
        $gameRecords->event_id = $params['event_id'];
        $gameRecords->got_money = $params['got_money'];
        $gameRecords->create_date = Date('Y-m-d H:i:s');
        $gameRecords->save();
        return true;
    }

    public function deleteGameRecordById($id)
    {
        return GameRecords::find($id)->delete();
    }
}
