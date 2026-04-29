<?php

/**
 * Check if the current admin has a specific permission.
 *
 * @param string $permission e.g., 'homepage.view'
 * @return bool
 */
function has_permission(string $permission): bool
{
    $adminId = session()->get('admin_id');
    if (!$adminId) {
        return false;
    }

    // Super Admin (role_id = 1) bypass
    $db = \Config\Database::connect();
    $roleQuery = $db->query("SELECT role_id FROM admins WHERE id = ?", [$adminId]);
    $roleId = $roleQuery->getRow()->role_id ?? 0;
    if ($roleId == 1) {
        return true;
    }

    $sql = "SELECT COUNT(*) as count 
            FROM role_permissions rp
            JOIN permissions p ON p.id = rp.permission_id
            JOIN admins a ON a.role_id = rp.role_id
            WHERE a.id = ? AND p.name = ?";
    $query = $db->query($sql, [$adminId, $permission]);
    $result = $query->getRow();
    return ($result->count ?? 0) > 0;
}

/**
 * Check if the admin has any of the given permissions.
 *
 * @param array $permissions
 * @return bool
 */
function has_any_permission(array $permissions): bool
{
    foreach ($permissions as $perm) {
        if (has_permission($perm)) {
            return true;
        }
    }
    return false;
}