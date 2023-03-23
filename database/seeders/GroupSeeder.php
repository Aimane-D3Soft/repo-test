<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Junges\ACL\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            // 'Administrateur',
            // 'Modérateur',
            'Testeur',
            'Développeur',
        ];
        foreach($groups as $group){
            Group::create([
                'name' => $group,
            ]);
        }
    }
}
