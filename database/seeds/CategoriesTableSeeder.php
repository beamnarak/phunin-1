<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $arr = ['กรองโซล่า','กรองดักน้ำ','กรองน้ำมัน','กรองไพล๊อต','กรองลม',
                    'กรองรวม','กรองอากาศ','กรองไฮดรอลิค','กรอบไฟท้าย','กระจก',
                    'กระดาษทราย','กระบอกเบรค',];
            
            for($i = 0; $i<count($arr); $i++){
                DB::table('categories')->insert([
                    'name' => $arr[$i],
                    'user_id' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
        
}

