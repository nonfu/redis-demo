<?php

namespace App\Nebula\Metrics;

use App\Models\Post;
use Larsklopstra\Nebula\Metrics\ValueMetric;

class PostCountMetric extends ValueMetric
{
    public function calculate()
    {
        return $this->count(Post::class);
    }

    public function cacheFor()
    {
        return now()->addHours(1);
    }

    public function label()
    {
        return 'New Posts';
    }
}
