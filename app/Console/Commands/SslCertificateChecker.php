<?php

namespace App\Console\Commands;

use App\Actions\Monitor\FetchAllMonitors;
use App\Actions\Monitor\ProcessSslCertificateData;
use App\Actions\Monitor\TrackMonitorLastCheckTimestamps;
use App\Enum\EventType;
use App\Models\Monitor;
use Illuminate\Console\Command;
use Spatie\SslCertificate\SslCertificate;

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
            ->filter(
                fn (Monitor $monitor) => $monitor->sslCheckExpired(),
            )
            ->each(function (Monitor $monitor) use ($sslDataProcessor, $monitorTimestampsUpdater) {
                // Determine certificate url
                $domainUrl = $monitor->domain->url;

                // Process and store certificate analytics
                $sslDataProcessor(
                    monitor: $monitor,
                    certificate: SslCertificate::createForHostName($domainUrl),
                );

                // Update monitor timestamps after certificate processing
                $monitorTimestampsUpdater(
                    monitor: $monitor,
                    type: EventType::SSL_CHECK,
                );
            });
    }
}
