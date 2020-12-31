<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrawlSource
 *
 * @property int $id
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlSource whereUrl($value)
 * @mixin \Eloquent
 */
class CrawlSource extends Model
{
    use HasFactory;
}
