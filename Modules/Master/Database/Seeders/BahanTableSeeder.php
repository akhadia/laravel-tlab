<?php

namespace Modules\Master\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Master\Entities\Bahan;
use Faker\Factory as Faker;

class BahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $faker = Faker::create();

        // $this->call("OthersTableSeeder");
 
        // for($i = 0; $i < 100; $i++) {
        // Bahan::create([
        //     'nama' => $faker->name,
        // ]);
        // }

        Bahan::insert([
            [
                'nama'  => 'Bawang Merah',
                'id_satuan'  => 1
            ],
            [
                'nama'  => 'Bawang Putih',
                'id_satuan'  => 1
            ],
            [
                'nama'  => 'Cabe Rawit',
                'id_satuan'  => 2
            ],
            [
                'nama'  => 'Nasi',
                'id_satuan'  => 2
            ],
            [
                'nama'  => 'Telur',
                'id_satuan'  => 3
            ],
            [
                'nama'  => 'Minyak',
                'id_satuan'  => 3
            ],
            [
                'nama'  => 'Ayam',
                'id_satuan'  => 4
            ],
            [
                'nama'  => 'Sayur Cesim',
                'id_satuan'  => 4
            ],
            [
                'nama'  => 'Kecap',
                'id_satuan'  => 5
            ],
            [
                'nama'  => 'Garam',
                'id_satuan'  => 5
            ],
            [
                'nama'  => 'Tomat',
                'id_satuan'  => 6
            ],
            [
                'nama'  => 'Wortel',
                'id_satuan'  => 6
            ],
            [
                'nama'  => 'Kemiri',
                'id_satuan'  => 7
            ],
            [
                'nama'  => 'Merica',
                'id_satuan'  => 7
            ],
            [
                'nama'  => 'Brokoli',
                'id_satuan'  => 8
            ],
              
        ]);
    }
    
}
