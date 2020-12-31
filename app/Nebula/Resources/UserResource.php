<?php

namespace App\Nebula\Resources;

use Illuminate\Validation\Rules\In;
use Larsklopstra\Nebula\Contracts\NebulaResource;
use Larsklopstra\Nebula\Fields\Input;

class UserResource extends NebulaResource
{
    protected $searchable = ['name', 'email'];

    public function icon()
    {
        return 'user-group';
    }

    public function columns(): array
    {
        return ['id', 'name', 'email', 'created_at'];
    }

    public function fields(): array
    {
        return [
            Input::make('name'),
            Input::make('email'),
            Input::make('password')->type('password')
        ];
    }
}
