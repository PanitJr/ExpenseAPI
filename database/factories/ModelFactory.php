<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Object\Users\Users::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make($faker->password)
    ];
});


$factory->define(App\Object\Role\Role::class, function (Faker\Generator $faker) {
    return [
        'rolename' => $faker->firstNameMale
    ];
});


$factory->define(App\CC\Tool\Object::class, function (Faker\Generator $faker) {
    return [];
});

//$factory->define(App\Object\Accounts\Accounts::class, function (Faker\Generator $faker) {
//    return [
//        'accountname' => $faker->name
//    ];
//});
//
//$factory->define(App\Object\Brand\Brand::class, function (Faker\Generator $faker) {
//    return [
//            "brandcode"=>"MB",
//            "brandname"=>$faker->name
//        ];
//});
