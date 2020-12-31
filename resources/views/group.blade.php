<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wechat Group</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="font-sans text-gray-900 antialiased">
    用户 {{ $name }} 加入了群聊 #{{ $id }}
</div>
</body>
<script type="text/javascript">
    let groupId = parseInt('{{ $id }}');

    window.axios.post('/groups/' + groupId + '/enter').then(resp => {
        console.log('我加入了群聊');
    }).catch(err => {
        console.log('加入群聊失败');
    });

    window.Echo.join('wechat.group.' + groupId)
        .listen('UserEnterGroup', event => {
            // 监听&接收服务端广播的消息
            console.log(event.user.name + '加入了群聊');
        });
</script>
</html>
