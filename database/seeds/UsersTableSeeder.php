<?php

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commonUser = User::create([
            'name' => 'Pedro Coelho',
            'document' => '10408291478',
            'email' => 'pdrbt@outlook.com',
            'password' => Hash::make('secret'),
        ]);

        $shopkeeper = User::create([
            'name' => 'Lojista dos santos',
            'document' => '10108291478',
            'email' => 'lojista@lojista.com',
            'password' => Hash::make('secret'),
        ]);

        Wallet::create([
            'user_id' => $commonUser->id,
            'value' => 100.0
        ]);

        Wallet::create([
            'user_id' => $shopkeeper->id,
            'value' => 100.0
        ]);

        $commonUser->assignRole('user');
        $shopkeeper->assignRole('shopkeeper');
    }
}
