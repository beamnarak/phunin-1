<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['อู่ซ่อม','โรงโม่','สโตร์', 'เครื่องจักรหนัก', 'ทีมระเบิด', 'รถพ่วง', 'รถขึ้นปากโม่', 'ห้องขาย', 'โรงครัว', 'ทั่วไป'];

        for($i = 0; $i<count($arr); $i++){
            DB::table('departments')->insert([
                'name' => $arr[$i],
                'user_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
