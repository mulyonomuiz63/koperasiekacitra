<?php
use App\Models\MenuModel;


function render_menu(array $menus, $parentId = null)
{
    foreach ($menus as $menu) {

        // ------------------ FILTER DASAR ------------------
        if ($menu['parent_id'] != $parentId) continue;
        if (!$menu['is_active']) continue;
        if (!can_view_menu($menu['id'])) continue;

        $icon = $menu['icon'] ?: 'ki-outline ki-menu fs-2';

        // ------------------ CEK CHILD VALID ------------------
        $hasChild = false;
        foreach ($menus as $child) {
            if (
                $child['parent_id'] == $menu['id'] &&
                $child['is_active'] &&
                can_view_menu($child['id'])
            ) {
                $hasChild = true;
                break;
            }
        }

        $isActive       = is_menu_active($menu['url']);
        $isActiveParent = has_active_child($menus, $menu['id']);

        // ====================================================
        // PARENT MENU (ACCORDION)
        // ====================================================
        if ($hasChild) {

            echo '<div class="menu-item menu-accordion '
                . ($isActiveParent ? 'here show' : '') . '" 
                data-kt-menu-trigger="click">';

            echo '<span class="menu-link">';
            echo '<span class="menu-icon"><i class="'.$icon.'"></i></span>';
            echo '<span class="menu-title">'.$menu['name'].'</span>';
            echo '<span class="menu-arrow"></span>';
            echo '</span>';

            echo '<div class="menu-sub menu-sub-accordion">';
            render_menu($menus, $menu['id']);
            echo '</div>';
            echo '</div>';

        // ====================================================
        // SINGLE MENU
        // ====================================================
        } else {

            echo '<div class="menu-item">';
            echo '<a class="menu-link '
                . ($isActive ? 'active' : '') . '" 
                href="'.menu_url($menu['url']).'">';

            echo '<span class="menu-icon"><i class="'.$icon.'"></i></span>';
            echo '<span class="menu-title">'.$menu['name'].'</span>';
            echo '</a>';
            echo '</div>';
        }
    }
}


/**
 * generate url menu (support admin group)
 */
function menu_url(string $url): string
{
    if ($url === '#' || empty($url)) {
        return '#';
    }

    // contoh hasil: /users
    return base_url(trim($url, '/'));
}

/**
 * cek apakah menu aktif
 */
function is_menu_active(string $menuUrl): bool
{
    if ($menuUrl === '#' || empty($menuUrl)) {
        return false;
    }

    // current path → users/edit/1
    $currentPath = trim(service('uri')->getPath(), '/');

    // menu path → users
    $menuPath = trim($menuUrl, '/');

    return $currentPath === $menuPath
        || str_starts_with($currentPath, $menuPath.'/');
}


/**
 * cek apakah parent memiliki child aktif
 */
function has_active_child(array $menus, int $parentId): bool
{
    foreach ($menus as $menu) {

        if ($menu['parent_id'] != $parentId) continue;
        if (!$menu['is_active']) continue;
        if (!can_view_menu($menu['id'])) continue;

        if (is_menu_active($menu['url'])) {
            return true;
        }

        if (has_active_child($menus, $menu['id'])) {
            return true;
        }
    }
    return false;
}



function getMenuBreadcrumb(string $uri)
{
    $menuModel = new \App\Models\MenuModel();

    $segments = explode('/', trim($uri, '/'));
    $basePath = '/' . ($segments[0] ?? '');

    $menu = $menuModel
        ->where('url', $basePath)
        ->where('is_active', 1)
        ->first();

    if (!$menu) {
        return [];
    }

    $breadcrumbs = [];

    // ======================
    // PARENT
    // ======================
    if (!empty($menu['parent_id'])) {

        $parent = $menuModel->find($menu['parent_id']);

        if ($parent) {
            $hasChild = $menuModel
                ->where('parent_id', $parent['id'])
                ->countAllResults() > 0;

            $breadcrumbs[] = [
                'name'      => $parent['name'],
                'url'       => $hasChild ? null : $parent['url'],
                'has_child' => $hasChild
            ];
        }
    }

    // ======================
    // MENU (SUB)
    // ======================
    $breadcrumbs[] = [
        'name'      => $menu['name'],
        'url'       => $menu['url'],
        'has_child' => false
    ];

    // ======================
    // ACTION
    // ======================
    $action = $segments[1] ?? null;

    $actionMap = [
        'create' => 'Tambah ' . $menu['name'],
        'edit'   => 'Edit ' . $menu['name'],
        'update' => 'Edit ' . $menu['name'],
    ];

    if ($action && isset($actionMap[$action])) {
        $breadcrumbs[] = [
            'name' => $actionMap[$action],
            'url'  => null
        ];
    } else {
        $breadcrumbs[] = [
            'name' => 'List ' . $menu['name'],
            'url'  => null
        ];
    }

    return $breadcrumbs;
}



