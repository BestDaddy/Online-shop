<?php

use App\Models\Role;
use App\Models\User;
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
        Role::insert([
            [
                'id'   => Role::ADMIN_ID,
                'name' => 'Администратор',
            ],
            [
                'id'   => Role::MANAGER_ID,
                'name' => 'Менеджер'
            ],
            [
                'id'   => Role::USER_ID,
                'name' => 'Пользователь'
            ],
            [
                'id'   => Role::COURIER_ID,
                'name' => 'Курьер'
            ]
        ]);

        User::updateOrCreate(['email' => 'admin@mail.ru'],[
            'first_name' => "Админ",
            'email' => "admin@mail.ru",
            'password' => bcrypt('password'),
            'role_id' => Role::ADMIN_ID,
        ]);

        User::updateOrCreate(['email' => 'manager@mail.ru'],[
            'first_name' => "Менеджер",
            'email' => "manager@mail.ru",
            'password' => bcrypt('password'),
            'role_id' => Role::MANAGER_ID,
        ]);

        User::updateOrCreate(['email' => 'user@mail.ru'],[
            'first_name' => "Пользователь",
            'email' => "user@mail.ru",
            'password' => bcrypt('password'),
            'role_id' => Role::USER_ID,
        ]);

        User::updateOrCreate(['email' => 'courier@mail.ru'],[
            'first_name' => "Курьер",
            'email' => "courier@mail.ru",
            'password' => bcrypt('password'),
            'role_id' => Role::COURIER_ID,
        ]);

    }
}
