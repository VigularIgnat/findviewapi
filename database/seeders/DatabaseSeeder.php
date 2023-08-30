<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Currency;
use Database\Factories\UserFactory;
use App\Services\CurrencyService;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        $currencies_arr= app('currency_service')->getArray();
        foreach ($currencies_arr as $currency) {
            Currency::factory()->create([
                'name'=>$currency,
                'course'=>0.1,
            ]);
        }
        
        User::factory(2)->create([
            "api_access"=>true,
        ]);


    }
}
