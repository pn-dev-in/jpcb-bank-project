<?php
$current = service('uri')->getSegment(2);
?>

<div class="sidebar">

    <!-- Logo -->
    <div class="logo-section text-center py-3">
        <img src="<?= base_url('assets/images/bank-logo.png') ?>" width="180">
        <h5 class="mt-2">Admin Panel</h5>
    </div>

    <ul class="menu">

        <!-- DASHBOARD -->
        <li>
            <a href="<?= base_url('admin/dashboard') ?>"
                class="<?= $current == 'dashboard' ? 'active' : '' ?>">
                🏠 Dashboard
            </a>
        </li>

        <!-- CONTENT MANAGEMENT -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('contentMenu')">📁 Content Management</a>

            <ul id="contentMenu" class="submenu">

                <li><a href="<?= base_url('admin/homepage') ?>">Hero Section</a></li>
                <li><a href="<?= base_url('admin/banners') ?>">Banners</a></li>
                <li><a href="<?= base_url('admin/notices') ?>">Notices</a></li>
                <li><a href="<?= base_url('admin/popups') ?>">Popups</a></li>

            </ul>
        </li>

        <!-- FEATURES -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('featuresMenu')">⚡ Features</a>

            <ul id="featuresMenu" class="submenu">

                <li><a href="<?= base_url('admin/products') ?>">Products & Services</a></li>
                <li><a href="<?= base_url('admin/quick-actions') ?>">Quick Actions</a></li>
                <li><a href="<?= base_url('admin/safety-section') ?>">Safety Section</a></li>
                <li><a href="<?= base_url('admin/grievance-steps') ?>">Grievance Steps</a></li>
                <li><a href="<?= base_url('admin/trust-stats') ?>">Trust Stat</a></li>

            </ul>
        </li>

        <!-- About Section Management -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('aboutSubmenu')">📄 About Section</a>
            <ul id="aboutSubmenu" class="submenu">
                <li><a href="<?= base_url('admin/about-stats') ?>">About Stats</a></li>
                <li><a href="<?= base_url('admin/about-values') ?>">Core Values</a></li>
                <li><a href="<?= base_url('admin/about-milestones') ?>">Milestones</a></li>
                <li><a href="<?= base_url('admin/board-members') ?>">Board Members</a></li>
                <li><a href="<?= base_url('admin/management-team') ?>">Management Team</a></li>
                <li><a href="<?= base_url('admin/awards') ?>">Awards</a></li>
                <li><a href="<?= base_url('admin/gallery-categories') ?>">Gallery Categories</a></li>
                <li><a href="<?= base_url('admin/gallery-items') ?>">Gallery Items</a></li>
            </ul>
        </li>

        <!-- DOCUMENTS -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('documentsMenu')">📑 Documents</a>

            <ul id="documentsMenu" class="submenu">

                <li><a href="<?= base_url('admin/documents/forms') ?>">PDF & Forms </a></li>
                <li><a href="<?= base_url('admin/documents') ?>">Policies & Reports </a></li>
                <li><a href="<?= base_url('admin/interest-rates') ?>">Interest Rates</a></li>

            </ul>
        </li>

        <!-- OPERATIONS -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('operationsMenu')">🏦 Operations</a>

            <ul id="operationsMenu" class="submenu">

                <li><a href="<?= base_url('admin/branches') ?>">Branches</a></li>
                <li><a href="<?= base_url('admin/complaints') ?>">Complaints</a></li>
                <li><a href="<?= base_url('admin/careers') ?>">Careers</a></li>

            </ul>
        </li>

        <!-- USER MANAGEMENT -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('userMenu')">👤 Users Management </a>

            <ul id="userMenu" class="submenu">

                <li><a href="<?= base_url('admin/users') ?>">Users</a></li>
                <li><a href="<?= base_url('admin/roles') ?>">Roles & Permissions</a></li>

            </ul>
        </li>

        <!-- SETTINGS -->
        <li class="menu-item">
            <a href="#" onclick="toggleMenu('settingsMenu')">⚙️ Settings</a>

            <ul id="settingsMenu" class="submenu">

                <li><a href="<?= base_url('admin/settings/edit') ?>">General Settings </a></li>
                <li><a href="<?= base_url('admin/social-links') ?>">Social Links</a></li>
                <li><a href="<?= base_url('admin/logs') ?>">Activity Logs</a></li>
                <li><a href="#">Security</a></li>

            </ul>
        </li>

        <!-- LOGOUT -->
        <li>
            <a href="<?= base_url('admin/logout') ?>" class="logout">
                🚪 Logout
            </a>
        </li>

    </ul>
</div>