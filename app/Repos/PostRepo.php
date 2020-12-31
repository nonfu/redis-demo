<?php
namespace App\Repos;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostRepo
{
    protected Post $post;
    protected string $trendingPostsKey = 'popular_posts';

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getById(int $id, array $columns = ['*'])
    {
        $cacheKey = 'post_' . $id;
        return Cache::remember($cacheKey, 1 * 60 * 60, function () use ($id, $columns) {
            return $this->post->select($columns)->find($id);
        });
    }

    public function getByManyId(array $ids, array $columns = ['*'], callable $callback = null)
    {
        $query = $this->post->select($columns)->whereIn('id', $ids);
        if ($query) {
            $query = $callback($query);
        }
        return $query->get();
    }

    // 文章浏览数 +1
    public function addViews(Post $post)
    {
        // 推送消息数据到队列，通过异步进程处理数据库更新
        Redis::rpush('post-views-increment', $post->id);
        return ++$post->views;
    }

    // 热门文章排行榜
    public function trending($num = 10)
    {
        $cacheKey = $this->trendingPostsKey . '_' . $num;
        return Cache::remember($cacheKey, 10 * 60, function () use ($num) {
            $postIds = Redis::zrevrange($this->trendingPostsKey, 0, $num - 1);
            if ($postIds) {
                $idsStr = implode(',', $postIds);
                return $this->getByManyId($postIds, ['*'], function ($query) use ($idsStr) {
                    return $query->orderByRaw('field(`id`, ' . $idsStr . ')');
                });
            }
        });
    }
}
