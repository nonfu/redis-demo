<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class SiteUV
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 按天为维度统计站点 UV
        $key = config('app.name') . '.uv.' . date('Ymd');
        // 根据用户是否登录获取用户唯一标识
        if (Auth::check()) {
            $userIdentifier = Auth::user()->getAuthIdentifier();
        } else {
            $userIdentifier = $request->getClientIp();
        }
        Redis::pfAdd($key, [$userIdentifier]);
        return $next($request);
    }
}
