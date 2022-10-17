<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user')->insert([
            "username" => "nickffcom",
            "is_admin" => IS_ADMIN,
            "money" => 25000,
            "password"=>Hash::make("noname2d")
        ]);
        DB::table('service')->insert([
            "name" => "Via XMDT 2029-2022",
            "description" => "Mua di ae oi re lam luon",
            "price" => 25000,
            "type"=>"via"
        ]);
        DB::table('service')->insert([
            "name" => "Via Co Full Email Password",
            "description" => "Mua di ae oi re lam luon",
            "price" => 15000,
            "type"=>"via"
        ]);
        DB::table('service')->insert([
            "name" => "Philipin Co Xmdt Full VIA",
            "description" => "Mua di ae oi re lam luon",
            "price" => 45000,
            "type"=>"via"
        ]);

        DB::table('service')->insert([
            "name" => "BM5 XMDN Limit 5m8",
            "description" => "Mua di ae oi re lam luon",
            "price" => 1125000,
            "type"=>"bm"
        ]);

        DB::table('service')->insert([
            "name" => "BM1 Bao Pay Len Bm3",
            "description" => "Mua di ae oi re lam luon",
            "price" => 105000,
            "type"=>"bm"
        ]);
        DB::table('service')->insert([
            "name" => "BM0 Die NLM Bao Pay Len Bm5 Kick Tut",
            "description" => "Mua di ae oi re lam luon",
            "price" => 800000,
            "type"=>"bm"
        ]);

        DB::table('service')->insert([
            "name" => "Clone US Reg Lau",
            "description" => "Mua di ae oi re lam luon",
            "price" => 7500,
            "type"=>"clone"
        ]);

        DB::table('service')->insert([
            "name" => "Clone VN NoVery",
            "description" => "Mua di ae oi re lam luon",
            "price" => 500,
            "type"=>"clone"
        ]);
        DB::table('service')->insert([
            "name" => "Clone VN Qua 282 >50 bb",
            "description" => "Mua di ae oi re lam luon",
            "price" => 2500,
            "type"=>"clone"
        ]);

        // ****************** 
        DB::table('data')->insert([
            "status" => CON_HANG,
            "service_id" => "1",
            "attr" => json_encode(DB_VIA("1000032532532","nonamekkkkk","2KFANALMGJAGSLMFSFKKF","hainaot9k@outlook.com","gasfaga","Ok con vk")),
        ]);
        DB::table('data')->insert([
            "status" => CON_HANG,
            "service_id" => "1",
            "attr" => json_encode(DB_VIA("103252364353","provjplam","9252KKFANALMGJKFSKGSKDASFKKF","caogiadongnai@outlook.com","kksafksaf","Ok con vk")),
        ]);
        DB::table('data')->insert([
            "status" => CON_HANG,
            "service_id" => "1",
            "attr" => json_encode(DB_VIA("100043625352335","haizzhuocnua","52532KHASFSKKKK@KFSFADS","hahahahhabun@outlook.com","kakashiii","Ok con vk")),
        ]);

    }
}