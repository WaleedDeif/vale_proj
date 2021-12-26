<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new App\Models\Type;
        $type->name ='Count Characters';
        $type->save();
        $type = new App\Models\Type;
        $type->name ='Count Lines';
        $type->save();
        $type = new App\Models\Type;
        $type->name ='Count Words';
        $type->save();
    }
}
