<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SqlListener
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
     * @param  =QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        foreach ($event->bindings as $key => &$value) {
            if (is_object($value) && ($value instanceof \DateTime)) {
                $value = $value->format('Y-m-d H:i:s');
            }
        }

        $sql = str_replace("?", "'%s'", $event->sql);

        $log = vsprintf($sql, $event->bindings);

        $log = '[' . date('Y-m-d H:i:s') . '] ' . $log . "\r\n";
        $filepath = storage_path('logs' . DIRECTORY_SEPARATOR . 'sql.log');
        file_put_contents($filepath, $log, FILE_APPEND);
    }
}
