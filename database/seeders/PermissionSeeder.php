<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Junges\ACL\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'afficher-produit',
            'créer-produit',
            'modifier-produit',
            'supprimer-produit',
            'imprimer-produit',
            'exporter-produit',
        ];

        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }
        
    }
}
