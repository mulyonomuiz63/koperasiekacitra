<?php

use App\Models\UserPermissionModel;
use App\Models\RolePermissionModel;

function can_view_menu(string $menuId): bool
{
    $db     = \Config\Database::connect();
    $userId = session()->get('user_id');
    $roleId = session()->get('role_id');

    // PRIORITAS USER PERMISSION
    $userPermission = $db->table('user_permissions')
        ->where('user_id', $userId)
        ->where('menu_id', $menuId)
        ->get()
        ->getRow();

    if ($userPermission) {
        return (bool) $userPermission->can_view;
    }

    // FALLBACK ROLE PERMISSION
    return $db->table('role_permissions')
        ->where('role_id', $roleId)
        ->where('menu_id', $menuId)
        ->where('can_view', 1)
        ->countAllResults() > 0;
}


/**
 * ================================
 * CEK AKSI (BUTTON)
 * ================================
 * $action = view | create | update | delete
 */
function can($menuId, $action)
{
    $userId = session()->get('user_id');
    $roleId = session()->get('role_id');

    if (!$userId || !$roleId) return false;

    $field = 'can_' . $action;

    // USER PERMISSION (ONLY IF = 1)
    $userPerm = model(UserPermissionModel::class)
        ->where('user_id', $userId)
        ->where('menu_id', $menuId)
        ->first();

    if ($userPerm !== null && (int)$userPerm[$field] === 1) {
        return true;
    }

    // ROLE PERMISSION
    $rolePerm = model(RolePermissionModel::class)
        ->where('role_id', $roleId)
        ->where('menu_id', $menuId)
        ->first();

    return $rolePerm !== null && (int)$rolePerm[$field] === 1;
}

