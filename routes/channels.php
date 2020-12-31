<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('wechat.group.{id}', function ($user, $id) {
    // 模拟微信群与用户映射关系列表，正式项目可以读取数据库获取
    $group_users = [
        [
            'group_id' => 1,
            'user_id' => 1,
        ],
        [
            'group_id' => 1,
            'user_id' => 2,
        ],
    ];
    // 判断微信群 ID 是否有效以及用户是否在给定群里，并以此作为授权通过条件
    $result = collect($group_users)->groupBy('group_id')
        ->first(function ($group, $groupId) use ($user, $id) {
            return $id == $groupId && $group->contains('user_id', $user->id);
        });
    return $result == null ? false : true;
});


