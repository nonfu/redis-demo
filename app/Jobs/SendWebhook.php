<?php

namespace App\Jobs;

use App\Services\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Throwable;

class SendWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public string $queue = 'service';
    // public int $tries = 3;

    public Service $service;
    public array $data;

    /**
     * Create a new job instance.
     *
     * @param Service $service
     * @param array $data
     */
    public function __construct(Service $service, array $data)
    {
        $this->service = $service;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 基于 HTTP 请求发送响应给调用方
        $response = Http::timeout(5)->post($this->service->url, $this->data);
        // 如果响应失败，则将此队列任务再次推送到队列进行重试
        if ($response->failed()) {
            // 第一次重试延迟 10s，第二次延迟 20s，依次类推...
            $this->release(10 * $this->attempts());
        }
    }

    // 重试过期时间
    public function retryUtil()
    {
        // 1 天后
        return now()->addDay();
    }

    // 任务执行失败后发送邮件通知给相关人员
    public function failed(Throwable $exception)
    {
        // Mail::to($this->service->developer->email)->send(...);
    }
}
