<?php

namespace App\Models;


class RolePermissionModel extends BaseModel
{
    protected $table      = 'role_permissions';
    
    protected $allowedFields = [
        'role_id',
        'menu_id',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];

    protected $useTimestamps = true;
    protected $returnType    = 'array';
    

    // =========================
    // Helper
    // =========================
    public function getRolePermissions($roleId)
    {
        return $this->where('role_id', $roleId)->findAll();
    }

    public function resetRolePermissions($roleId)
    {
        return $this->where('role_id', $roleId)->delete();
    }
}
