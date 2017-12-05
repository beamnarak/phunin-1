<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['อัน','ชุด','เส้น','ลูก','กล่อง','ตัว','ท่อน','เครื่อง',
        'แผ่น','ม้วน','คู่','ลัง','ถัง','กระป๋อง','ขวด','ถุง','แพค','กระสอบ',
        'กิโลกรัม','กรัม','ลิตร','ชิ้น','หลอด','ก้าน','ดอก','แท่ง','ด้าม','ใบ','ตลับ',];
        
        for($i = 0; $i<count($arr); $i++){
            DB::table('units')->insert([
                'name' => $arr[$i],
                'user_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
