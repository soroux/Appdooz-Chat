<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Type::create([
            'name'=>'text',
        ]);
        Type::create([
            'name'=>'file',
        ]);
    }
}
