<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    // Pour stocker les noms des utilisateurs
    protected $userNames = [];

    public function model(array $row)
    {
        // Ajoutez le nom de l'utilisateur à la liste pour l'utiliser plus tard
        $this->userNames[] = $row['nom'];

        // Vérifiez si l'utilisateur existe déjà par son email
        if (User::where('email', $row['email'])->exists()) {
            // Lancer une exception avec le nom de l'utilisateur
            throw new \Exception("L'utilisateur avec l'email {$row['email']} existe déjà. Nom: {$row['nom']}");
        }

        // Créez un nouvel utilisateur s'il n'existe pas
        return new User([
            'name' => $row['nom'],
            'email' => $row['email'],
            'password' => bcrypt('password'),
            'role' => $this->getRole($row['role']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:admin,user',
        ];
    }

    private function getRole($role)
    {
        $validRoles = ['admin', 'user'];
        return in_array($role, $validRoles) ? $role : 'user';
    }

    public function onFailure(Failure ...$failures)
    {
        $errorMessages = []; // Créer un tableau pour stocker les messages d'erreur

        foreach ($failures as $failure) {
            $row = $failure->row(); // Numéro de la ligne échouée

            // Récupérer le nom de l'utilisateur correspondant à la ligne échouée
            $userName = $this->userNames[$row - 1] ?? 'Inconnu'; // Utilisez -1 pour le décalage de l'index

            // Ajouter le message d'erreur avec le nom de l'utilisateur
            $errorMessages[] = "Erreur pour l'utilisateur {$userName} à la ligne {$row}: " . implode(', ', $failure->errors());
        }

        // Enregistrer le tableau d'erreurs dans la session
        session()->flash('import_errors', $errorMessages);
    }
}