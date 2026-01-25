<?php
//untuk di header
function render_menu_header(array $menus, $parentId = null)
{
    foreach ($menus as $menu) {

        // ------------------ FILTER DASAR ------------------
        if ($menu['parent_id'] != $parentId) continue;
        if (!$menu['is_active']) continue;
        if (!can_view_menu($menu['id'])) continue;

        $icon = $menu['icon'] ?: 'ki-outline ki-menu fs-1';

        // ------------------ CEK CHILD ------------------
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

        $isActive = is_menu_active($menu['url']);

        // ====================================================
        // SINGLE MENU (GRID STYLE)
        // ====================================================
        if (!$hasChild) {

            echo '<div class="col-lg-6 mb-3">';
            echo '<div class="menu-item p-0 m-0">';

            echo '<a href="'.menu_url($menu['url']).'" class="menu-link '
                . ($isActive ? 'active' : '') . '">';

            echo '<span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">';
            echo '<i class="'.$icon.' text-primary"></i>';
            echo '</span>';

            echo '<span class="d-flex flex-column">';
            echo '<span class="fs-6 fw-bold text-gray-800">'.$menu['name'].'</span>';

            // optional description
            if (!empty($menu['description'])) {
                echo '<span class="fs-7 fw-semibold text-muted">'.$menu['description'].'</span>';
            }

            echo '</span>';
            echo '</a>';
            echo '</div>';
            echo '</div>';

        }
        // ====================================================
        // JIKA MENU PARENT (SKIP / ATAU BISA DIBUAT GROUP)
        // ====================================================
        else {
            // opsi 1: tampilkan title saja
            echo '<div class="col-12 mb-4">';
            echo '<h4 class="fw-bold text-gray-700">'.$menu['name'].'</h4>';
            echo '<div class="row">';
            render_menu_header($menus, $menu['id']);
            echo '</div>';
            echo '</div>';
        }
    }
}

//untuk di sidebar
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
function has_active_child(array $menus, string $parentId): bool
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

    // Trim spasi dan slash
    $uri = trim($uri, '/');
    $segments = explode('/', $uri);

    /**
     * LOGIKA BARU:
     * Mencari kecocokan URL paling mendekati di database.
     * Kita akan mencoba mencocokkan segmen 0 + segmen 1 (misal: sw-anggota/menus)
     */
    $possibleUrl = count($segments) >= 2 ? $segments[0] . '/' . $segments[1] : $segments[0];
    
    // Cek full path atau partial path
    $menu = $menuModel
        ->where('is_active', 1)
        ->groupStart()
            ->where('url', '/' . $uri) // Coba /sw-anggota/menus
            ->orWhere('url', '/' . $possibleUrl) // Coba /sw-anggota/menus (jika ada action di belakang)
            ->orWhere('url', '/' . $segments[0]) // Coba /menus
        ->groupEnd()
        ->first();

    if (!$menu) {
        return [];
    }

    $breadcrumbs = [];

    // --- PARENT ---
    if (!empty($menu['parent_id'])) {
        $parent = $menuModel->find($menu['parent_id']);
        if ($parent) {
            $hasChild = $menuModel->where('parent_id', $parent['id'])->countAllResults() > 0;
            $breadcrumbs[] = [
                'name'      => $parent['name'],
                'url'       => $hasChild ? null : $parent['url'],
                'has_child' => $hasChild
            ];
        }
    }

    // --- MENU (SUB) ---
    $breadcrumbs[] = [
        'name'      => $menu['name'],
        'url'       => $menu['url'],
        'has_child' => false
    ];

    // --- ACTION DETECTION ---
    // Mencari action (create/edit) dari segmen terakhir
    $lastSegment = end($segments);
    $actionMap = [
        'create' => 'Tambah ' . $menu['name'],
        'edit'   => 'Edit ' . $menu['name'],
        'update' => 'Edit ' . $menu['name'],
    ];

    // Jika segmen terakhir adalah action, tambahkan breadcrumb
    if (isset($actionMap[$lastSegment])) {
        $breadcrumbs[] = [
            'name' => $actionMap[$lastSegment],
            'url'  => null
        ];
    } else {
        // Jika URL saat ini persis sama dengan URL menu, tampilkan "List"
        if ('/' . $uri == $menu['url']) {
            $breadcrumbs[] = [
                'name' => 'List ' . $menu['name'],
                'url'  => null
            ];
        }
    }

    return $breadcrumbs;
}



