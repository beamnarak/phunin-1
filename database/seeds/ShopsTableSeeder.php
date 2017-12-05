<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['สีวาลี','ส. นครเชียงกง','นครพนมแทรคเตอร์','ลาวฟูดา','แขก อัดสายไฮดรอลิค','เพชรสมร',
        'กะโหลก','เจริญรวมน็อต','ลาวยุ่น','โรงกลึงพัฒนาลาว','เจพี แทรคเตอร์','วีดูโอ','KY แมชชีนเนอรี่','พันเกลียว',
        'สมศักดิ์ประดับยนต์','โรงกลึงนครพนมจักรกล','BM Part','World One Part',
        'เฟืองทอง','โมโทร','ไทยเมทัล','วีเหลี่ยม',];
        
        for($i = 0; $i<count($arr); $i++){
            DB::table('shops')->insert([
                'name' => $arr[$i],
                'user_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
