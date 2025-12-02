<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // --- 1️⃣ Création des rôles ---
        $roles = ['Direction', 'Comptable', 'Réception', 'Restauration'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // --- 2️⃣ Liste des utilisateurs à créer ---
        $users = [
            [
                'name' => 'Direction',
                'prenom' => 'Admin',
                'email' => 'direction@miadjoebeachresort.com',
                'password' => Hash::make('Miadjoe2@25Beach'),
                'role' => 'Direction',
            ],
            [
                'name' => 'Comptable',
                'prenom' => 'Finance',
                'email' => 'comptable@miadjoe.com',
                'password' => bcrypt('password'),
                'role' => 'Comptable',
            ],
            [
                'name' => 'Réception',
                'prenom' => 'Accueil',
                'email' => 'reception@miadjoe.com',
                'password' => Hash::make('password'),
                'role' => 'Réception',
            ],
            [
                'name' => 'Restauration',
                'prenom' => 'Cuisine',
                'email' => 'restauration@miadjoe.com',
                'password' => Hash::make('password'),
                'role' => 'Restauration',
            ],
        ];

        // --- 3️⃣ Création des utilisateurs + assignation du rôle ---
        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'prenom' => $data['prenom'],
                    'password' => $data['password'],
                ]
            );

            $user->assignRole($data['role']);
        }

        $this->command->info('✅ Rôles et utilisateurs de base créés avec succès !');

        

    }
}
