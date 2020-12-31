<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class HyperLogLogDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uv:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UV Statistic Demo With Redis HyperLogLog';

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
        $key = 'site.uv.pf.20201225';
        Redis::pipeline(function ($pipe) use ($key) {
            for ($i = 0; $i < 10000; $i++) {
                $pipe->pfAdd($key, ['user.' . $i]);
            }
        });
        $headers = ['Real UV', 'Statistic UV'];
        $this->table($headers, [[10000, Redis::pfCount($key)]]);
    }
}
