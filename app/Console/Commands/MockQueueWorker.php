<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MockQueueWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mock:queue-worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mock Queue Worker';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('监听消息队列 post-views-increment...');
        while (true) {
            // 从队列中取出消息数据
            $postId = Redis::lpop('post-views-increment');
            // 将当前文章浏览数 +1，并存储到对应 Sorted Set 的 score 字段
            if ($postId && Post::query()->where('id', $postId)->increment('views')) {
                Redis::zincrby('popular_posts', 1, $postId);
                $this->info("更新文章 #{$postId} 的浏览数");
            }
        }
    }
}
