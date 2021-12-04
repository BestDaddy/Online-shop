<?php

namespace App\Listeners;

use App\Models\Item;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ItemCacheListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        cache()->forget('items'); //forget all the cache data initially

        $items = Item::all(); //fetch all data

        cache()->forever('items', $items); // and put them into cache forever
        Log::info('Item cached');
    }
}
