<?php

namespace App\Observers;

use App\Models\GameRecords;
use App\Notifications\GameRecordsNotification;
use Illuminate\Support\Facades\Notification;

class GameRecordsObserver
{
    /**
     * Handle the GameRecords "created" event.
     *
     * @param \App\Models\GameRecords $gameRecords
     * @return void
     */
    public function created(GameRecords $gameRecords)
    {
        Notification
            ::route('mail', env('MAIL_FROM_ADDRESS')) //Sending mail to subscriber
            ->notify(new GameRecordsNotification($gameRecords));
    }

    /**
     * Handle the GameRecords "updated" event.
     *
     * @param \App\Models\GameRecords $gameRecords
     * @return void
     */
    public function updated(GameRecords $gameRecords)
    {
        echo "updated";
//        dispatch(new GameRecordsUpDateJob($gameRecords));
    }

    /**
     * Handle the GameRecords "deleted" event.
     *
     * @param \App\Models\GameRecords $gameRecords
     * @return void
     */
    public function deleted(GameRecords $gameRecords)
    {
        //
    }

    /**
     * Handle the GameRecords "restored" event.
     *
     * @param \App\Models\GameRecords $gameRecords
     * @return void
     */
    public function restored(GameRecords $gameRecords)
    {
        //
    }

    /**
     * Handle the GameRecords "force deleted" event.
     *
     * @param \App\Models\GameRecords $gameRecords
     * @return void
     */
    public function forceDeleted(GameRecords $gameRecords)
    {
        //
    }
}
