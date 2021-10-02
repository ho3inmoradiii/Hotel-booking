<?php

namespace Database\Factories;

use App\Models\Bookable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BookableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr=[
            'Villa',
            'House',
            'Cottage',
            'Luxury villas',
            'Rooms'
        ];

        return [
            'title' => $this->faker->city() . ' ' . Arr::random($arr),
            'description' => $this->faker->text(),
        ];
    }
}
