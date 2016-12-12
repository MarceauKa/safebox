<?php

namespace App\Jobs;

use App\Libraries\Browsershot;
use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TakeSiteScreenshot implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Site
     */
    public $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $browsershot = new Browsershot();
            $browsershot
                ->setBinPath(base_path() . '/node_modules/.bin/phantomjs')
                ->setUrl($this->site->url)
                ->setWidth(1024)
                ->setHeight(768)
                ->setTimeout(3000)
                ->save(public_path($this->site->screenshot_file));
        } catch (\Exception $e) {
            unset($e);
        }
    }
}
