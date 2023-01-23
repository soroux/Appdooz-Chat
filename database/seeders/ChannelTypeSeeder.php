<?php

namespace Database\Seeders;

use App\Models\ChannelType;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Database\Seeder;

class ChannelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ChannelType::create([
            'name'=>'privet-channel',
        ]);
        ChannelType::create([
            'name'=>'group-channel',
        ]);
    }
}
