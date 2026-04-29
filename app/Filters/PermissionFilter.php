<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $currentUri = $request->getUri()->getPath();
    
    // Skip login/logout
    if (strpos($currentUri, 'admin/login') !== false || strpos($currentUri, 'admin/logout') !== false) {
        return;
    }

    $segments = explode('/', trim($currentUri, '/'));
    if (count($segments) < 2 || $segments[0] !== 'admin') {
        return;
    }

    $module = str_replace('-', '_', $segments[1] ?? 'dashboard');
    $actionSegment = $segments[2] ?? '';
    $method = $request->getMethod();
    $action = $this->getActionFromUrl($actionSegment, $method);

    // Special case for homepage
    if ($module === 'homepage') {
        if ($actionSegment === 'edit-hero') $module = 'homepage';
        elseif ($actionSegment === 'trust-cards') $module = 'homepage';
        elseif ($actionSegment === 'create-card') $module = 'homepage';
        elseif ($actionSegment === 'store-card') $module = 'homepage';
        elseif ($actionSegment === 'edit-card') $module = 'homepage';
        elseif ($actionSegment === 'update-card') $module = 'homepage';
        elseif ($actionSegment === 'delete-card') $module = 'homepage';
        else $module = 'homepage';
    }

    $requiredPermission = $module . '.' . $action;
    
    // DEBUG: Log the permission being checked
    log_message('error', 'Checking permission: ' . $requiredPermission . ' for URI: ' . $currentUri);
    
    if (has_permission($requiredPermission)) {
        return;
    }
    
    return redirect()->to('/admin/dashboard')
        ->with('error', "You do not have permission to access this page (required: $requiredPermission)");
}

    private function getActionFromUrl(string $actionSegment, string $method): string
    {
        // Map URL segment and HTTP method to permission action
        switch ($actionSegment) {
            case 'create':
                return 'create';
            case 'store':
                return 'create';
            case 'edit':
                return 'edit';
            case 'update':
                return 'edit';
            case 'delete':
                return 'delete';
            case 'import':
                return 'import';
            case 'process-import':
                return 'import';
            case 'sample-csv':
                return 'view'; // sample CSV is just a download
            case 'approve':
                return 'approve';
            case 'print':
                return 'print';
            case 'assign':
                return 'assign';
            case 'view':
                return 'view';
            default:
                // No action segment: treat as listing (view)
                if ($method === 'GET') {
                    return 'view';
                }
                // POST without specific action could be create/update – default to 'edit' for safety
                return 'edit';
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}