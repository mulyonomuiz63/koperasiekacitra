<?php
//untuk di header
function render_menu_classic(array $menus, $parentId = null, $isFirstLevel = true)
{
    foreach ($menus as $menu) {
        // Filter Dasar
        if ($menu['parent_id'] != $parentId || !$menu['is_active'] || !can_view_menu($menu['id'])) continue;

        $icon = $menu['icon'] ?: 'ki-duotone ki-element-11';
        $isActive = is_menu_active($menu['url']);

        // Cek apakah menu ini memiliki anak (Sub-menu)
        $hasChild = false;
        foreach ($menus as $child) {
            if ($child['parent_id'] == $menu['id'] && $child['is_active'] && can_view_menu($child['id'])) {
                $hasChild = true;
                break;
            }
        }

        if ($hasChild) {
            // === ITEM DENGAN SUB-MENU (ACCORDION/DROPDOWN) ===
            // Tambahkan class 'here show' jika ada anak yang sedang aktif
            $isChildActive = false; // Anda bisa buat fungsi cek recursive jika perlu
            
            echo '';
            echo '<div data-kt-menu-trigger="click" class="menu-item menu-accordion ' . ($isActive ? 'here show' : '') . '">';
            echo '    <span class="menu-link">';
            
            if ($isFirstLevel) {
                echo '        <span class="menu-icon">';
                echo '            <i class="' . $icon . ' fs-2">';
                // Render path otomatis (duotone biasanya butuh ini)
                echo '                <span class="path1"></span><span class="path2"></span><span class="path3"></span>';
                echo '            </i>';
                echo '        </span>';
            } else {
                echo '        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>';
            }

            echo '        <span class="menu-title">' . $menu['name'] . '</span>';
            echo '        <span class="menu-arrow"></span>';
            echo '    </span>';

            echo '    ';
            echo '    <div class="menu-sub menu-sub-accordion">';
                         // Rekursif untuk level berikutnya
                         render_menu_classic($menus, $menu['id'], false);
            echo '    </div>';
            echo '    ';
            echo '</div>';
            echo '';

        } else {
            // === ITEM TUNGGAL (LINK) ===
            echo '';
            echo '<div class="menu-item">';
            echo '    <a class="menu-link ' . ($isActive ? 'active' : '') . '" href="' . menu_url($menu['url']) . '">';
            
            if ($isFirstLevel) {
                echo '        <span class="menu-icon">';
                echo '            <i class="' . $icon . ' fs-2">';
                echo '                <span class="path1"></span><span class="path2"></span>';
                echo '            </i>';
                echo '        </span>';
            } else {
                echo '        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>';
            }

            echo '        <span class="menu-title">' . $menu['name'] . '</span>';
            echo '    </a>';
            echo '</div>';
            echo '';
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



