<?php

namespace App\Console\Commands;

use App\Actions\Monitor\FetchAllMonitors;
use App\Actions\Monitor\ProcessSslCertificateData;
use App\Actions\Monitor\TrackMonitorLastCheckTimestamps;
use App\Enum\EventType;
use App\Models\Monitor;
use Illuminate\Console\Command;
use Spatie\QueueableAction\ActionJob;

class SslCertificateChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:ssl-certificates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies integrity of the SSL certificate of websites under monitoring';

    /**
     * Execute the console command.
     */
    public function handle(
        FetchAllMonitors $monitorsRetriever,
        ProcessSslCertificateData $sslDataProcessor,
        TrackMonitorLastCheckTimestamps $monitorTimestampsUpdater,
    ): void {
        $monitors = $monitorsRetriever(
            where: [
                ['ssl_check', '=', true],
            ],
            with: ['domain'],
        );

        $monitors
            ->each(
                fn (Monitor $monitor) => $sslDataProcessor
                    ->onQueue()
                    // Process and store ssl certificate analytics
                    ->execute(
                        monitor: $monitor,
                        certificateUrl: $monitor->domain->url,
                    )
                    ->chain([
                        // Then update monitor timestamps after certificate processing
                        new ActionJob(
                            $monitorTimestampsUpdater::class,
                            [
                                $monitor,
                                EventType::SSL_CHECK,
                            ],
                        ),
                    ]),
            )
            ->count();
    }
}
