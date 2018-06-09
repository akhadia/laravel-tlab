<?php

namespace Modules\Master\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Master\Entities\Satuan;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        Satuan::insert([
            ['nama'  => 'Piring'],
            ['nama'  => 'Buah'],
            ['nama'  => 'Secukupnya'],
            ['nama'  => 'Siung'],
            ['nama'  => 'Helai'],
            ['nama'  => 'Sendok Teh'],
            ['nama'  => 'Butir'],
            ['nama'  => 'Biji'],
            ['nama'  => 'Gelas'],
            ['nama'  => 'Sendok Makan'],
              
        ]);
    }
}
