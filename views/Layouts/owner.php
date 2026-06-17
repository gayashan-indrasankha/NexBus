<?php
// views/layouts/owner.php
// Expects $contentViewFile from BaseController::render()

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', $uri)));
$module = $segments[0] ?? 'B';
$page   = $segments[1] ?? 'dashboard';

$user    = $_SESSION['user'] ?? null;
$displayName = $user ? trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) : '';
$displayName = $displayName !== '' ? $displayName : ($user['name'] ?? ($user['full_name'] ?? ''));
$initial = $user ? strtoupper(substr($displayName !== '' ? $displayName : 'B', 0, 1)) : '?';
$email   = $user['email'] ?? 'owner@nexbus.lk';
$name    = $displayName !== '' ? $displayName : 'Bus Owner';
$isDashboardPage = $path === '/B' || $path === '/B/dashboard' || ($module === 'B' && ($page === 'dashboard' || $page === ''));

$ownerCssFile = __DIR__ . '/../../public/assets/css/owner.css';
$ownerJsFile = __DIR__ . '/../../public/assets/js/bus_owner.js';
$ownerCssVersion = is_file($ownerCssFile) ? (string) filemtime($ownerCssFile) : '1';
$ownerJsVersion = is_file($ownerJsFile) ? (string) filemtime($ownerJsFile) : '1';

if (!defined('BASE_URL')) define('BASE_URL', '/B');
?>
<!doctype html>
<html lang="en" data-theme="<?= $_SESSION['prefs']['theme'] ?? 'light' ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bus Owner Dashboard</title>
  <link rel="stylesheet" href="/assets/css/owner.css?v=<?= htmlspecialchars($ownerCssVersion, ENT_QUOTES) ?>">
  <script defer src="/assets/js/bus_owner.js?v=<?= htmlspecialchars($ownerJsVersion, ENT_QUOTES) ?>"></script>
  <link rel="icon" href="/assets/images/logo.png" type="image/png">

</head>
<body class="<?= $isDashboardPage ? 'owner-dashboard-page' : '' ?>">

<header class="topbar">
  <div class="brand">
    <div class="logo"><img src="/assets/images/logo.png" alt="NexBus Logo"></div>
    <div>
      <div class="app">Bus Management System</div>
      <div class="sub">NexBus Sri Lanka</div>
    </div>
  </div>
  <div class="right">
    <div class="user">Bus Owner Dashboard</div>
    <div class="date"><?= date('l d F Y'); ?></div>
  </div>
</header>

<div class="app-shell">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo"><img src="/assets/images/logo.png" alt="NexBus Logo"></div>
      <div>
        <div class="app">Bus Management System</div>
        <div class="sub">NexBus Sri Lanka</div>
      </div>
    </div>

    <div class="sidebar-head">
      <div class="mini-logo">🚌</div>
      <div>
        <div class="sb-title">Bus Owner Dashboard</div>
        <div class="sb-sub">Owner Portal</div>
      </div>
    </div>

    <nav class="menu">
      <a href="/B/dashboard" class="menu-item<?= ($page==='dashboard')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg></i>
        Dashboard
      </a>
      <a href="/B/fleet" class="menu-item<?= ($page==='fleet')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><rect x="3" y="5" width="18" height="12" rx="2"/><path d="M3 11h18M7 17h.01M17 17h.01"/></svg></i>
        Fleet
      </a>
      <a href="/B/drivers" class="menu-item<?= ($page==='drivers')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></i>
        Staff
      </a>
      <a href="/B/attendance" class="menu-item<?= ($page==='attendance')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg></i>
        Attendance
      </a>
      <a href="/B/earnings" class="menu-item<?= ($page==='earnings')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></i>
        Earnings
      </a>
      <a href="/B/performance" class="menu-item<?= ($page==='performance')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg></i>
        Performance
      </a>
      <a href="/B/feedback" class="menu-item<?= ($page==='feedback')?' active':'' ?>">
        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><path d="M21 15a4 4 0 0 1-4 4H7l-4 3V5a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/></svg></i>
        Feedback
      </a>
    </nav>

    <div class="sidebar-profile">
      <a href="/B/profile" class="profile-card">
        <div class="profile-avatar"><?= $initial ?></div>
        <div class="profile-meta">
          <div class="profile-name"><?= htmlspecialchars($name) ?></div>
          <div class="profile-email"><?= htmlspecialchars($email) ?></div>
        </div>
      </a>
      <a href="/logout" class="profile-logout">⇦ Logout</a>
    </div>

    <div class="sidebar-foot">
      &copy; <?= date('Y'); ?> National Transport Commission<br>
      <div class="version">Version 1.0.0</div>
    </div>
  </aside>

  <main id="content" class="active">
    <?php require $contentViewFile; ?>
  </main>
</div>

</body>
</html>
