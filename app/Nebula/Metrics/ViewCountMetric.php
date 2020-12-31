<?php

namespace App\Nebula\Metrics;

use App\Models\Post;
use Larsklopstra\Nebula\Metrics\ValueMetric;

class ViewCountMetric extends ValueMetric
{
    public function calculate()
    {
        return $this->sum(Post::class, 'views');
    }

    public function cacheFor()
    {
        return now()->addMinutes(10);
    }

    public function label()
    {
        return 'Post Views';
    }
}
