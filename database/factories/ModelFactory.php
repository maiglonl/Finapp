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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Finapp\Models\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = bcrypt('secret'),
		'remember_token' => str_random(10),
	];
});

$factory->state(\Finapp\Models\User::class, 'admin', function (Faker\Generator $faker) {
	static $password;

	return [
		'role' => \Finapp\Models\User::ROLE_ADMIN,
	];
});

$factory->define(\Finapp\Models\BankAccount::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->city,
		'agency' => rand(100, 600),
		'account' => rand(10000, 60000).'-'.rand(0,9),
	];
});

$factory->define(\Finapp\Models\Client::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail
	];
});

$factory->define(\Finapp\Models\CategoryExpense::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name
	];
});

$factory->define(\Finapp\Models\CategoryRevenue::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name
	];
});

$factory->define(\Finapp\Models\BillPay::class, function (Faker\Generator $faker) {
	return [
		'date_due' => $faker->dateTimeBetween('0 years','+2 years')->format('Y-m-d'),
		'name' => $faker->word,
		'value' => $faker->numberBetween(10,1000),
		'done' => rand(0,1)
	];
});

$factory->define(\Finapp\Models\BillReceive::class, function (Faker\Generator $faker) {
	return [
		'date_due' => $faker->dateTimeBetween('0 years','+2 years')->format('Y-m-d'),
		'name' => $faker->word,
		'value' => $faker->numberBetween(10,1000),
		'done' => rand(0,1)
	];
});