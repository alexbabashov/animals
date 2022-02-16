<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Option #1
        // $kind = $this->faker->unique()->randomElement(
        //     [
        //     "cat",
        //     "dog",
        //     "bird",
        //     "bear",
        //     ]
        // );
        // $recoeds =[
        //     [
        //         'kind' => $kind,
        //         'size_max' => $this->faker->numberBetween(50, 250),
        //         'age_max' => $this->faker->numberBetween(10, 100),
        //         'grow_factor' => $this->faker->randomFloat(1, 0.4, 1.5),
        //         'avatar' => $kind
        //     ],
        // ];
        // foreach($recoeds as $rec) {
        //     DB::table('images')->insert($rec);
        //   }

        //Option #2
        Animal::factory()->count(4)->create();
    }
}
