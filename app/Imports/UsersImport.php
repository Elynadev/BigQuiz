<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
          // Vérifiez si l'utilisateur existe déjà par son email
          if (User::where('email', $row['email'])->exists()) {
            return null; // Ignorez cet enregistrement
        }

        // Créez un nouvel utilisateur s'il n'existe pas
        return new User([
            'name'  => $row['nom'], // Assurez-vous que les clés correspondent aux en-têtes de votre fichier Excel
            'email' => $row['email'],
            'password' => bcrypt('password'), // Mettez un mot de passe par défaut ou gérez-le autrement
            'role' => $this->getRole($row['role']), // Fonction pour vérifier le rôle
        ]);
    }
    private function getRole($role)
    {
        $validRoles = ['admin', 'user'];
        $role = in_array($role, $validRoles) ? $role : 'user';
        // dd($role); // Vérifiez le rôle retourné
        return $role;
    }

}
