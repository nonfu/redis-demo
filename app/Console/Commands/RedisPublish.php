<?php

namespace App\Console\Commands;

use App\Events\UserEnterGroup;
use App\Events\UserSendMessage;
use App\Events\UserSignedUp;
use Hamcrest\Core\Is;
use http\Client\Curl\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis Publish Message';

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
        $user = \App\Models\User::find(1);
        //event(new UserSignedUp($user));
        //$message = '你好, 学院君!';
        $groupId = 1;
        //event(new UserSendMessage($user, $message, $groupId));
        broadcast(new UserEnterGroup($user, $groupId))->toOthers();
    }
}
