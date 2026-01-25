<?php

namespace App\Models;


class UserPermissionModel extends BaseModel
{
    protected $table      = 'user_permissions';

    protected $allowedFields = [
        'user_id',
        'menu_id',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];


    protected $returnType = 'array';

    // =============================
    // HELPER METHODS (OPTIONAL)
    // =============================

    /**
     * Ambil permission user per menu
     */
    public function getUserPermissions($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    /**
     * Ambil permission spesifik user + menu
     */
    public function getPermission($userId, $menuId)
    {
        return $this->where([
            'user_id' => $userId,
            'menu_id' => $menuId
        ])->first();
    }

    /**
     * Reset permission user (override)
     */
    public function resetUserPermissions($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}
