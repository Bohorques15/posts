<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      //countries request
      $response = [];

      $URL = "https://restcountries.eu/rest/v2/all";

      $request = file_get_contents($URL);

      $response = json_decode($request,true);

      foreach ($response as $country) {
        $new_country = new Country();
        $new_country->name = isset($country['translations']["es"]) ? $country['translations']["es"] : $country['name'] ;
        $new_country->save();
      }
    }
}
