<?php

namespace App\Jobs;

use App\Models\Movie;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StreamMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $movie;

    public function __construct(Movie $theMovie)
    {
        $this->movie = $theMovie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lowBitrate = (new X264('aac'))->setKiloBitrate(100);
        $midBitrate = (new X264('aac'))->setKiloBitrate(250);
        $highBitrate = (new X264('aac'))->setKiloBitrate(500);

        FFMpeg::fromDisk('movies')
            ->open( $this->movie->path )
            ->exportForHLS()
            ->onProgress(function ($percentage) {
                $this->movie->update([
                    'percent' => $percentage
                ]);
            })
            ->setSegmentLength(10) // optional
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->save("{$this->movie->id}/{$this->movie->id}.m3u8");
    }
}
