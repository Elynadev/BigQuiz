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

    protected $userNames = [];

    public function model(array $row)
{
    logger('Traitement de la ligne : ' . json_encode($row));

    if (empty($row['nom'])) {
        throw new \Exception("Le nom de l'utilisateur est manquant.");
    }

    // Assurez-vous de stocker les informations nécessaires ici
    $this->userNames[] = [
        'name' => $row['nom'],
        'email' => $row['email'],
        'id' => User::where('email', $row['email'])->value('id'), // Récupérez l'ID de l'utilisateur si existant
    ];

    if (User::where('email', $row['email'])->exists()) {
        throw new \Exception("L'utilisateur avec l'email {$row['email']} existe déjà. Nom: {$row['nom']}");
    }

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
        $errorMessages = [];

        foreach ($failures as $failure) {
            $row = $failure->row();
            $userName = $this->userNames[$row - 1] ?? '';
            $email = $failure->values()['email'] ?? '';
            $userId = User::where('email', $email)->value('id');

            $errorMessages[] = "Erreur pour l'utilisateur {$userName},dont Email est : {$email}, ID: {$userId} à la ligne {$row}: " . implode(', ', $failure->errors());
        }

        session()->flash('import_errors', $errorMessages);
    }
}