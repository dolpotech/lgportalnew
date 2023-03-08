<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = getUserType();
        $type = $types[array_rand($types)];

        $ministryRoles = [2, 3, 4];
        $lgRoles = [5, 6, 7];


        $lgId = null;
        $ministryId = null;

        if ($type == 'ministry') {
            $roleId = $ministryRoles[array_rand($ministryRoles)];
            $ministryId = $this->getMinistryIds()[array_rand($this->getMinistryIds())];
        }

        if ($type == 'local_government') {
            $roleId = $lgRoles[array_rand($lgRoles)];
            $lgId = $this->getLgIds()[array_rand($this->getLgIds())];
        }

        return [
            'first_name'    => $this->faker->firstName,
            'last_name'     => $this->faker->lastName,
            'email'         => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'lg_id'         => $lgId,
            'ministry_id'   => $ministryId,
            'role_id'       => $roleId,
            'password'      => bcrypt('12345678'),
            'phone_no'      => '13826482364',
            'type'          => $type,
            'status'        => 1,
            'remember_token' => Str::random(10),
        ];
    }

    public function getLgIds(): array
    {
        $lg_rang_1 = range(1, 10);
        $lg_rang_2 = range(138, 148);
        $lg_rang_3 = range(274, 284);

        return array_merge($lg_rang_1, array_merge($lg_rang_2, $lg_rang_3));
    }

    public function getMinistryIds(): array
    {
        return range(1, 22);
    }


}
