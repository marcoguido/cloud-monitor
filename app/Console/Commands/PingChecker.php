<?php

namespace App\Console\Commands;

use App\Actions\Monitor\FetchAllMonitors;
use App\Actions\Monitor\ProcessPingData;
use App\Actions\Monitor\TrackMonitorLastCheckTimestamps;
use App\Enum\EventType;
use App\Models\Monitor;
use Illuminate\Console\Command;
use Spatie\QueueableAction\ActionJob;

class PingChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies whether websites being monitored are reachable or not';

    /**
     * Execute the console command.
     */
    public function handle(

        FetchAllMonitors $monitorsRetriever,
        ProcessPingData $pingDataProcessor,
        TrackMonitorLastCheckTimestamps $monitorTimestampsUpdater,
    ): void {
        $monitors = $monitorsRetriever(['ping_check' => true]);

        $executionCount = $monitors
            ->filter(
                fn (Monitor $monitor) => $monitor->pingCheckExpired(),
            )
            ->each(
                fn (Monitor $monitor) => $pingDataProcessor
                    ->onQueue()
                    // Process and store ping analytics
                    ->execute($monitor)
                    ->chain([
                        // Then update monitor timestamps after certificate processing
                        new ActionJob(
                            $monitorTimestampsUpdater::class,
                            [
                                $monitor,
                                EventType::PING,
                            ],
                        ),
                    ]),
            )
            ->count();
    }
}
