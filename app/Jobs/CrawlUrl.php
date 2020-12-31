<?php

namespace App\Jobs;

use App\Models\CrawlSource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CrawlUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CrawlSource $crawlSource;

    /**
     * Create a new job instance.
     *
     * @param CrawlSource $crawlSource
     */
    public function __construct(CrawlSource $crawlSource)
    {
        $this->crawlSource = $crawlSource;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(1);  // 模拟爬取工作
        $this->crawlSource->status = 1;
        $this->crawlSource->save();
    }
}
