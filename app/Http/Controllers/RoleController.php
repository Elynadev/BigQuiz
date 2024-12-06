<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    // Méthode pour créer des rôles
    public function createRoles()
    {
        // Création des rôles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        return response()->json(['message' => 'Rôles créés avec succès.']);
    }

    // Méthode pour créer des permissions
    public function createPermissions()
    {
        // Création des permissions
        $viewProfilePermission = Permission::create(['name' => 'view_profile']);
        // Ajoutez d'autres permissions ici...
        return response()->json(['message' => 'Permissions créées avec succès.']);
    }

    // Méthode pour assigner un rôle à un utilisateur
    public function assignRoleToUser(Request $request, $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->assignRole($request->role);
            return response()->json(['message' => 'Rôle assigné avec succès.']);
        }
        return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
    }

    // Méthode pour attribuer une permission à un rôle
    public function assignPermissionToRole(Request $request, $roleId)
    {
        $role = Role::find($roleId);
        if ($role) {
            $role->givePermissionTo($request->permission);
            return response()->json(['message' => 'Permission attribuée avec succès.']);
        }
        return response()->json(['message' => 'Rôle non trouvé.'], 404);
    }
}