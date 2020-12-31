<?php

namespace App\Http\Controllers;

use App\Events\PostViewed;
use App\Jobs\ImageUploadProcessor;
use App\Models\Post;
use App\Repos\PostRepo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    protected PostRepo $postRepo;

    public function __construct(PostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
        $this->middleware('auth')->only(['create', 'store']);
    }

    // 浏览文章
    public function show($id)
    {
        // 定义一个单位时间内限定请求上限的限流器，每秒最多支持 100 个请求
        return Redis::throttle("posts.${id}.show.concurrency")
            ->allow(100)->every(1)
            ->then(function () use ($id) {
                // 正常访问
                $post = $this->postRepo->getById($id);
                event(new PostViewed($post));
                return view('posts.show', ['post' => $post]);
            }, function () {
                // 触发并发访问上限
                abort(429, 'Too Many Requests');
            });
    }

    // 获取热门文章排行榜
    public function popular()
    {
        $posts = $this->postRepo->trending(10);
        if ($posts) {
            dump($posts->toArray());
        }
    }

    // 发布文章页面
    public function create()
    {
        return view('posts.create');
    }

    // 发布文章处理
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:10',
            'image' => 'required|image|max:1024'  // 尺寸不能超过1MB
        ]);

        $post = new Post($data);
        $post->user_id = $request->user()->id;
        try {
            if ($post->save()) {
                $image = $request->file('image');
                // 获取图片名称
                $name = $image->getClientOriginalName();
                // 获取图片二进制数据后通过 Base64 进行编码
                // $content = base64_encode($image->getContent());
                $path = $image->store('temp');
                // 通过图片处理任务类将图片存储工作推送到 uploads 队列异步处理
                ImageUploadProcessor::dispatch($name, $path, $post)->onQueue('uploads');
                return redirect('posts/' . $post->id);
            }
            return back()->withInput()->with(['status' => '文章发布失败，请重试']);
        } catch (QueryException $exception) {
            return back()->withInput()->with(['status' => '文章发布失败，请重试']);
        }
    }
}
