<?php
// Only admin role is used in JPCB admin panel
$role = 'admin';
$pageTitle = $pageTitle ?? 'Dashboard';
$userName = session()->get('admin_name') ?? session()->get('name') ?? 'Admin';
$profileImage = session()->get('profile_image');
$gender = strtolower((string) session()->get('gender'));
$gender = ($gender === 'female') ? 'female' : 'male';

$maleDefault = base_url('admin-assets/images/users/avatar-3.jpg');
$femaleDefault = base_url('admin-assets/images/users/avatar-2.jpg');

$uploadedProfile = null;
if (!empty($profileImage)) {
    $profileFile = FCPATH . 'uploads/profile/' . basename((string) $profileImage);
    if (is_file($profileFile)) {
        $uploadedProfile = base_url('uploads/profile/' . basename((string) $profileImage));
    }
}
$imageToShow = $uploadedProfile ?? (($gender === 'male') ? $femaleDefault : $maleDefault);

$dashboardUrl = base_url('admin/dashboard');
$profileUrl = base_url('admin/profile');

$adminNotifications = $unreadNotifications ?? [];
$adminUnreadCount = $notificationCount ?? count($adminNotifications);
?>

<header class="app-topbar" id="header">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <!-- Logo -->
            <a href="<?= esc($dashboardUrl) ?>" class="logo">
                <span class="logo-light">
                    <span class="logo-lg">
                        <div class="brand-lockup">
                            <div class="brand-mark-wrap">
                                <img src="<?= base_url('admin-assets/images/logo-sm.png') ?>" alt="JPCB" class="brand-mark">
                            </div>
                            <div class="brand-copy">
                                <span class="brand-name">JPCB Bank</span>
                                <span class="brand-tag">ADMIN</span>
                            </div>
                        </div>
                    </span>
                    <span class="logo-sm">
                        <img src="<?= base_url('admin-assets/images/logo-sm.png') ?>" alt="JPCB mark">
                    </span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg">
                        <div class="d-flex align-items-center gap-2">

                            <img src="<?= base_url('admin-assets/images/bank-logo.png') ?>"
                                alt="JPCB Bank"
                                style="height: 45px; width: auto;">

                        </div>
                    </span>
                    <span class="logo-sm">
                        <img src="<?= base_url('admin-assets/images/bank-logo.png') ?>" alt="JPCB mark" style="width: 32px;">
                    </span>
                </span>
            </a>

            <!-- Sidebar toggle button -->
            <button class="sidenav-toggle-button px-2" type="button">
                <i class="ri-menu-5-line fs-24"></i>
            </button>

            <!-- Page title -->
            <div class="topbar-item d-none d-md-flex px-2">
                <h4 class="page-title fs-20 fw-semibold mb-0">
                    <?= esc($pageTitle) ?>
                </h4>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Dark/Light mode toggle (optional) -->
            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ri-moon-line light-mode-icon fs-22"></i>
                    <i class="ri-sun-line dark-mode-icon fs-22"></i>
                </button>
            </div>

            <!-- Notifications dropdown -->
            <div class="topbar-item dropdown">
                <a class="topbar-link position-relative px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" href="#" role="button">
                    <i class="ri-notification-3-line fs-22"></i>
                    <?php if ($adminUnreadCount > 0): ?>
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                            <?= $adminUnreadCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow p-0" style="width: 340px;">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifications</h6>
                        <?php if ($adminUnreadCount > 0): ?>
                            <a href="<?= base_url('admin/notifications/read-all') ?>" class="small text-primary">Mark all as read</a>
                        <?php endif; ?>
                    </div>
                    <div style="max-height: 320px; overflow-y: auto;">
                        <?php if (empty($adminNotifications)): ?>
                            <div class="p-3 text-center text-muted">No notifications</div>
                        <?php else: ?>
                            <?php foreach ($adminNotifications as $note): ?>
                                <a href="<?= site_url('admin/notifications/read/' . $note['id']) ?>"
                                    class="dropdown-item d-flex align-items-start gap-2 py-2 border-bottom">
                                    <div>
                                        <i class="ri-notification-3-line text-warning fs-18"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">
                                            <?= esc($note['title'] ?? 'Notification') ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= esc($note['message'] ?? '') ?>
                                        </div>
                                        <?php if (!empty($note['created_at'])): ?>
                                            <div class="text-muted small">
                                                <?= date('d M, h:i A', strtotime($note['created_at'])) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- User dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" href="#" role="button">
                        <img src="<?= esc($imageToShow) ?>" width="36" height="36" class="rounded-circle me-lg-2 object-fit-cover" alt="user-image">
                        <span class="d-lg-flex flex-column gap-1 d-none">
                            <h5 class="my-0 topbar-user-name"><?= esc($userName) ?></h5>
                        </span>
                        <i class="ri-arrow-down-s-line d-none d-lg-block align-middle ms-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Signed in as Administrator</h6>
                        </div>
                        <a href="<?= esc($profileUrl) ?>" class="dropdown-item">
                            <i class="ri-account-circle-line me-1 fs-16 align-middle"></i>
                            <span class="align-middle">My Account</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('admin/logout') ?>" class="dropdown-item fw-semibold text-danger">
                            <i class="ri-logout-box-line me-1 fs-16 align-middle"></i>
                            <span class="align-middle">Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    /* Add custom styles for the topbar if needed */
    .app-topbar .logo {
        display: inline-flex;
        align-items: center;
        min-height: var(--ct-topbar-height);
        padding: 0 0.35rem 0 0;
        line-height: 1;
    }

    .logo .logo-lg {
        display: inline-flex;
        align-items: center;
    }

    .brand-lockup {
        display: inline-flex;
        align-items: center;
        gap: 0.85rem;
    }

    .brand-mark-wrap {
        width: 2.55rem;
        height: 2.55rem;
        border-radius: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.08);
        box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.08);
        flex-shrink: 0;
    }

    .brand-mark {
        width: 2rem;
        height: 2rem;
    }

    .brand-copy {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1;
    }

    .brand-name {
        font-family: "Outfit", "Public Sans", sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: -0.04em;
    }

    .brand-tag {
        margin-top: 0.28rem;
        font-size: 0.58rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .logo-dark .brand-name {
        color: #0f172a;
    }

    .logo-dark .brand-tag {
        color: #64748b;
    }

    .logo-light .brand-mark-wrap {
        background: rgba(255, 255, 255, 0.12);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
    }

    .logo-light .brand-name {
        color: #f8fafc;
    }

    .logo-light .brand-tag {
        color: rgba(248, 250, 252, 0.72);
    }

    @media (max-width: 767.98px) {
        .app-topbar .brand-copy {
            display: none;
        }

        .app-topbar .logo {
            min-height: auto;
            padding-right: 0;
        }

        .app-topbar .brand-lockup {
            gap: 0;
        }

        .app-topbar .brand-mark-wrap {
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 0.8rem;
            background: transparent;
            box-shadow: none;
        }
    }
</style>

<!-- Notification auto‑refresh (for admin) -->
<script>
    (function() {
        const toggle = document.querySelector('.topbar-item.dropdown a.topbar-link');
        const list = document.querySelector('.dropdown-menu .p-3 + div');
        const fetchUrl = <?= json_encode(base_url('admin/notifications/fetch')) ?>;
        const readBaseUrl = <?= json_encode(rtrim(base_url('admin/notifications/read'), '/')) ?>;

        if (!toggle || !list) return;

        const updateBadge = (count) => {
            let badge = toggle.querySelector('.badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle';
                    toggle.appendChild(badge);
                }
                if (badge.textContent != count) {
                    badge.classList.add('pulse');
                    setTimeout(() => badge.classList.remove('pulse'), 300);
                }
                badge.textContent = count;
            } else if (badge) {
                badge.remove();
            }
        };

        const renderNotifications = (notifications) => {
            list.innerHTML = '';
            if (!notifications.length) {
                list.innerHTML = '<div class="p-3 text-center text-muted">No notifications</div>';
                return;
            }
            notifications.forEach(n => {
                const item = document.createElement('div');
                item.className = 'dropdown-item d-flex gap-2 py-2 border-bottom ' + (n.is_read == 0 ? 'bg-light fw-bold' : 'text-muted opacity-75');
                item.style.cursor = 'pointer';
                item.innerHTML = `
                <div><i class="ri-notification-3-line text-warning fs-18"></i></div>
                <div class="flex-grow-1">
                    <div class="fw-semibold small">${n.title || 'Notification'}</div>
                    <div class="text-muted small">${n.message || ''}</div>
                    <div class="text-muted small">${n.created_at || ''}</div>
                </div>
            `;
                item.addEventListener('click', () => {
                    fetch(`${readBaseUrl}/${n.id}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(() => {
                            item.classList.remove('bg-light');
                            loadNotifications();
                        });
                    if (n.link) window.location.href = '/' + n.link;
                });
                list.appendChild(item);
            });
        };

        const loadNotifications = () => {
            fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    updateBadge(Number(data.count || 0));
                    renderNotifications(data.notifications || []);
                })
                .catch(() => {});
        };

        loadNotifications();
        setInterval(loadNotifications, 5000);
    })();
</script>