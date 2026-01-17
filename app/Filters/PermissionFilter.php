<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$arguments || count($arguments) < 2) {
            return;
        }

        [$menuSlug, $action] = $arguments;

        $menu = model('MenuModel')
            ->where('slug', $menuSlug)
            ->first();

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        if (!can($menu['id'], $action)) {
            return redirect()->to('/dashboard')
                ->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
