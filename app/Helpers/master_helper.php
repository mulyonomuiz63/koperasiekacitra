<?php
// load helper lain secara CI4
helper([
    'permission',
    'menu',
    'setting'
]);
function canAccess($menuSlug, $action)
{
    $db = \Config\Database::connect();
    $userId = session()->get('user_id');

    return $db->table('users u')
        ->join('roles r','r.id=u.role_id')
        ->join('role_permissions rp','rp.role_id=r.id')
        ->join('permissions p','p.id=rp.permission_id')
        ->join('menus m','m.id=p.menu_id')
        ->where('u.id',$userId)
        ->where('m.slug',$menuSlug)
        ->where("p.can_$action",1)
        ->countAllResults() > 0;
}

function getUserMenus()
{
    $db = \Config\Database::connect();
    $userId = session()->get('user_id');

    return $db->table('users u')
        ->select('m.*')
        ->join('role_permissions rp','rp.role_id=u.role_id')
        ->join('permissions p','p.id=rp.permission_id')
        ->join('menus m','m.id=p.menu_id')
        ->where('u.id',$userId)
        ->where('p.can_view',1)
        ->groupBy('m.id')
        ->orderBy('m.id','ASC')
        ->get()->getResult();
}

