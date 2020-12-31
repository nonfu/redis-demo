<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Websocket</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
    <h1>Broadcast Test</h1>
    <p>{{ $message ?? '' }}</p>
</body>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    let groupId = 1;

    window.Echo.private('wechat.group.' + groupId).listen('UserSendMessage', event => {
        console.log(event.user.name + ' Says ' + event.message);
    });

    window.Echo.join('wechat.group.' + groupId)
        .joining(user => {
            // 正在加入频道
            console.log(user);
        }).here(users => {
            // 已加入频道
            console.log('在线用户数: ' + users.length);
        }).leaving(user => {
            // 离开频道
            console.log(user);
        }).listen('UserEnterGroup', event => {
            // 监听&接收服务端广播的消息
            console.log(event.user.name + '加入了群聊');
        });
</script>
</html>
