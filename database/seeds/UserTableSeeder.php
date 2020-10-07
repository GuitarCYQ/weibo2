<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(50)->create();

        $user = User::find(1);
        $user->name = 'Guitar';
        $user->email = 'guitarcyq@sina.com';
        $user->password = bcrypt('111111');
        $user->save();
    }
}
