<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Exécuter les seeds.
     */
    public function run(): void
    {
        // Liste des rôles de base
        $roles = [
            'Direction',
            'Comptable',
            'Réception',
            'Restauration',
            'Caisse',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Exemple de permissions de base (optionnel)
        $permissions = [
            'voir tableau de bord',
            'gérer réservations',
            'gérer clients',
            'gérer factures',
            'gérer menus',
            'gérer ventes de services',
            'gérer la caisse'
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Attribution automatique de quelques permissions
        $roleDirection = Role::where('name', 'Direction')->first();
        if ($roleDirection) {
            $roleDirection->givePermissionTo(Permission::all());
        }

        $roleReception = Role::where('name', 'Réception')->first();
        if ($roleReception) {
            $roleReception->givePermissionTo(['voir tableau de bord', 'gérer réservations', 'gérer clients']);
        }

        $roleComptable = Role::where('name', 'Comptable')->first();
        if ($roleComptable) {
            $roleComptable->givePermissionTo(['voir tableau de bord', 'gérer factures']);
        }

        $roleRestauration = Role::where('name', 'Restauration')->first();
        if ($roleRestauration) {
            $roleRestauration->givePermissionTo(['voir tableau de bord', 'gérer menus']);
        }

        $this->command->info('✅ Rôles et permissions de base créés avec succès !');
    }
}
