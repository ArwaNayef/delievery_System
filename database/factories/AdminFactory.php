<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>'arwa',
            'email'=>'arwa1@hotmail.com',
            'password'=>Crypt::encrypt('123456'),
        ];
    }
}
