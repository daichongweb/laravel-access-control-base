<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnterprisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enterprises')->insert([
            'name' => '特抱抱',
            'key' => Str::random(32),
            'corp_id' => 'wwdd5de763c22737b4',
            'corp_secret' => 'WkBE7V4LOtPlgYJd76_n9mo_D30bxT2ToB7s2Gxslvs',
            'app_id' => 'wx1fd8bd85dba2a4ef',
            'app_secret' => 'dc1f4398bbaa5a0016cbb433e0946f13'
        ]);
        $enterprise_id = DB::table('enterprises')->orderBy('id', 'desc')->value('id');
        Db::table('members')->insert([
            'enterprise_id' => $enterprise_id,
            'corp_user_id' => '780cec62c8d1d744575e0a711d3d00d4',
            'pid' => 0,
            'name' => 'daichong',
            'username' => 'daichongweb',
            'avatar' => 'https://thirdwx.qlogo.cn/mmopen/vi_32/oorUNaMR2FibMTib7Tv7P676SEJPWubVZ3La8h9FNlMeq2UeB8SlVQv4ylicRJBef4FMYndEdWeFRr6jPqDeZLo5Q/132',
            'email' => 'daichongweb@foxmail.com',
            'password' => bcrypt('daichongweb'),
            'type' => 0
        ]);
    }
}
