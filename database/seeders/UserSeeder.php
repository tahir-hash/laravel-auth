<?php

  namespace Database\Seeders;

  use Illuminate\Database\Seeder;
  use App\Models\LocalCommunity;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\LazyCollection;

  class UserSeeder extends Seeder 
  {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::disableQueryLog();
    DB::table('local_communities')->truncate();

    LazyCollection::make(function () {
      $handle = fopen(public_path("comunities.csv"), 'r');
      
      while (($line = fgetcsv($handle, 4096)) !== false) {
        $dataString = implode(", ", $line);
        $row = explode(';', $dataString);
        yield $row;
      }

      fclose($handle);
    })
    ->skip(1)
    ->chunk(1000)
    ->each(function (LazyCollection $chunk) {
      $records = $chunk->map(function ($row) {
      return [
        "state" => $row[0],
        "community" => $row[1],
        "district" => $row[2]
      ];
      })->toArray();
      
      DB::table('communities')->insert($records);
    });
  }
}