<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition(): array
    {
        return [
            'tables_id' => 'TBL-' . Str::upper(Str::random(5)),
            'tables_name' => $this->faker->word(),
            'tables_capacity' => $this->faker->numberBetween(1, 10),
            'tables_location' => $this->faker->optional()->city(),
            'tables_status' => $this->faker->randomElement(Table::STATUSES),
        ];
    }
}
