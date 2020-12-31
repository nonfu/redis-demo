<?php

namespace App\Nebula\Resources;

use App\Nebula\Metrics\PostCountMetric;
use App\Nebula\Metrics\ViewCountMetric;
use Larsklopstra\Nebula\Contracts\NebulaResource;
use Larsklopstra\Nebula\Fields\Input;
use Larsklopstra\Nebula\Fields\Textarea;

class PostResource extends NebulaResource
{
    protected $searchable = ['title'];

    public function metrics(): array
    {
        return [
            new PostCountMetric,
            new ViewCountMetric,
        ];
    }

    public function indexFields(): array
    {
        return [
            Input::make('id'),
            Input::make('title'),
            Input::make('views'),
            Input::make('created_at'),
        ];
    }

    public function fields(): array
    {
        return [
            Input::make('title'),
            Input::make('content'),
            Input::make('created_at'),
            Input::make('updated_at'),
        ];
    }

    public function createFields(): array
    {
        return [
            Input::make('title'),
            Textarea::make('content'),
        ];
    }

    public function editFields(): array
    {
        return [
            Input::make('title'),
            Textarea::make('content'),
        ];
    }
}
