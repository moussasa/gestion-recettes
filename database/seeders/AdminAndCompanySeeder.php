<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminAndCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Création de l'utilisateur admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('11111111'),
                
            ]
        );

        // Mise à jour des informations de l'entreprise
        CompanySetting::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Mon Entreprise Culinaire',
                'address' => 'Bamako AMLI',
                'phone' => '+223 70808983',
                'email' => 'contact@monentreprise.com',
                'about' => 'Entreprise spécialisée dans les recettes gastronomiques depuis 2010.',
                'logo' => null, 
            ]
        );

        $this->command->info('Utilisateur admin et informations de l\'entreprise créés avec succès!');
    }
}
