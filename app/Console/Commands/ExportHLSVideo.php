<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ExportHLSVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:export-hls {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '動画のHLSエンコーディング';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');

        $lowBitrate = (new X264)->setKiloBitrate(250);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        $this->info('Start Converting.');

        FFMpeg::fromDisk('local')
            ->open("videos/{$filename}.mp4")
            ->exportForHLS()
            ->addFormat($lowBitrate)
            ->addFormat($highBitrate)
            ->onProgress(fn ($progress) => $this->info("Progress {$progress}%"))
            ->toDisk('public')
            ->save("video/{$filename}.m3u8");

        $this->info('Done!');
    }
}

