<?php

namespace Database\Factories;

use App\Models\CrawlSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrawlSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CrawlSource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url,
        ];
    }
}
