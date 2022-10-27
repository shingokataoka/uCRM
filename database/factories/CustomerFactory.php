<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 電話番号からハイフンを消す
        $tel = str_replace('-', '', fake()->phoneNumber);
        // 住所から郵便番号を消す
        $address = mb_substr(fake()->address, 9);
        
        return [
            'name' => fake()->name,
            'kana' => fake()->kanaName,
            'tel' => $tel,
            'email' => fake()->email,
            'postcode' => fake()->postcode,      // 郵便番号
            'address' => $address,      // 住所
            'birthday' => fake()->dateTime,      //誕生日
            'gender' => fake()->numberBetween(0,2),    // 0男性 1女性 2その他
            'memo' => fake()->realText,
        ];
    }
}
