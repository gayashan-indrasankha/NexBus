<?php
// views/bus_owner/dashboard.php
$user = $_SESSION['user'] ?? [];
$greeting = (int) date('H') < 12 ? 'Good Morning' : ((int) date('H') < 17 ? 'Good Afternoon' : 'Good Evening');
$uname = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
$uname = $uname !== '' ? $uname : ($user['name'] ?? ($user['full_name'] ?? 'Owner'));

$totalBuses = (int) ($total_buses ?? 0);
$activeBuses = (int) ($active_buses ?? 0);
$totalDrivers = (int) ($total_drivers ?? 0);
$totalRev = (float) ($total_revenue ?? 0);
$maintBuses = (int) ($maintenance_buses ?? 0);
$activePct = $totalBuses > 0 ? round($activeBuses / $totalBuses * 100) : 0;
$liveCount = max($activeBuses, 0);
$shortDate = date('d M Y');
$fullDate = date('l d F Y');
?>

<section id="ownerDashboard" class="owner-dashboard" aria-label="Bus owner dashboard">
  <div class="owner-dashboard-top">
    <h1>Bus Owner Dashboard</h1>
    <div class="owner-dashboard-date">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2" />
        <path d="M16 2v4M8 2v4M3 10h18" />
      </svg>
      <?= htmlspecialchars($fullDate) ?>
    </div>
  </div>

  <div class="dash-hero">
    <span class="dash-hero-dots" aria-hidden="true"></span>
    <span class="dash-hero-road" aria-hidden="true"></span>

    <div class="dash-hero-left">
      <div class="dash-greeting-chip">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10" />
          <path d="M12 6v6l4 2" />
        </svg>
        <span id="dash-live-time">--:--</span>
        <span class="dash-chip-dot">&middot;</span>
        <span><?= htmlspecialchars($shortDate) ?></span>
      </div>
      <div class="dash-greeting">
        <?= htmlspecialchars($greeting) ?>, <strong><?= htmlspecialchars($uname) ?></strong>
        <span class="dash-wave" aria-hidden="true">&#128075;</span>
      </div>
      <p class="dash-sub">Here's what's happening with your fleet today.</p>
    </div>

    <div class="dash-hero-scene" aria-hidden="true">
      <img src="/assets/images/heroSectionImage.png" alt="Bus fleet illustration" class="dash-hero-img" />
    </div>
  </div>

  <div class="stats-grid owner-dashboard-stats">
    <div class="stat-card kpi-fleet">
      <div class="kpi-icon-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="1" y="7" width="22" height="13" rx="2" />
          <path d="M1 13h22M5 20v2M19 20v2M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2" />
        </svg>
      </div>
      <div class="stat-content">
        <div class="stat-label">Total Fleet</div>
        <div class="stat-value"><?= $totalBuses ?></div>
        <div class="kpi-bar-wrap">
          <div class="kpi-bar kpi-bar--fleet" style="width:100%"></div>
        </div>
        <div class="stat-change"><?= $activeBuses ?> active &middot; <?= $maintBuses ?> in maintenance</div>
      </div>
    </div>

    <div class="stat-card kpi-active">
      <div class="kpi-icon-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
          <path d="M22 4 12 14.01l-3-3" />
        </svg>
      </div>
      <div class="stat-content">
        <div class="stat-label">Active Buses</div>
        <div class="stat-value"><?= $activeBuses ?></div>
        <div class="kpi-bar-wrap">
          <div class="kpi-bar kpi-bar--active" style="width:<?= $activePct ?>%"></div>
        </div>
        <div class="stat-change"><?= $activePct ?>% fleet utilisation</div>
      </div>
    </div>

    <div class="stat-card kpi-drivers">
      <div class="kpi-icon-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
          <circle cx="9" cy="7" r="4" />
          <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
      </div>
      <div class="stat-content">
        <div class="stat-label">Total Staff</div>
        <div class="stat-value"><?= $totalDrivers ?></div>
        <div class="kpi-bar-wrap">
          <div class="kpi-bar kpi-bar--drivers" style="width:100%"></div>
        </div>
        <div class="stat-change">Registered drivers &amp; conductors</div>
      </div>
    </div>

    <div class="stat-card kpi-revenue">
      <div class="kpi-icon-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10" />
          <path d="M12 6v2M12 16v2M9.5 9.5a2.5 2.5 0 0 1 5 0c0 1.5-2.5 2-2.5 2s-2.5.5-2.5 2a2.5 2.5 0 0 0 5 0" />
        </svg>
      </div>
      <div class="stat-content">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value kpi-revenue-val">
          <span class="kpi-currency">LKR</span><?= number_format($totalRev) ?>
        </div>
        <div class="kpi-bar-wrap">
          <div class="kpi-bar kpi-bar--revenue" style="width:100%"></div>
        </div>
        <div class="stat-change">All-time earnings</div>
      </div>
    </div>
  </div>

  <div class="owner-dashboard-grid">
    <div class="owner-dashboard-left">
      <div class="card owner-dashboard-card dash-map-card">
        <h3 class="card-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z" />
            <circle cx="12" cy="10" r="3" />
          </svg>
          Live Fleet Tracker
          <span id="bo-live-count" class="dash-live-count">
            <span class="dash-live-dot" aria-hidden="true"></span>
            <?= $liveCount ?> buses live
          </span>
        </h3>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
        <div id="bo-live-map" class="dash-map"></div>
        <p class="dash-map-note">Shows only your private-company buses &middot; auto-refreshes every 15s</p>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        <script>
          (function () {
            var OWNER_ID = <?= json_encode((int) (($_SESSION['user']['private_operator_id'] ?? 0))) ?>;
            var q = new URLSearchParams(window.location.search || '');
            var focusBus = String(q.get('bus') || q.get('focus_bus') || '').trim();
            var focusLat = parseFloat(q.get('lat') || '');
            var focusLng = parseFloat(q.get('lng') || '');
            var focusDone = false;

            if (!window.L) {
              var countFallback = document.getElementById('bo-live-count');
              if (countFallback) countFallback.textContent = 'Map unavailable';
              return;
            }

            var map = L.map('bo-live-map', {
              zoomControl: true,
              attributionControl: true
            }).setView([6.927, 79.861], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
              maxZoom: 18
            }).addTo(map);

            var markers = {};

            function busIcon(speed) {
              var over = speed > 60;
              var fill = over ? '#dc2626' : '#16a34a';
              var ring = over ? '#fca5a5' : '#86efac';
              var pulse = over ? '#fee2e2' : '#dcfce7';
              var svg =
                '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="54" viewBox="0 0 44 54">'
                + '<ellipse cx="22" cy="52" rx="9" ry="3" fill="rgba(0,0,0,.22)"/>'
                + '<circle cx="22" cy="20" r="19" fill="' + pulse + '" opacity=".55"/>'
                + '<path d="M22 2C13.16 2 6 9.16 6 18c0 10.5 16 32 16 32S38 28.5 38 18C38 9.16 30.84 2 22 2Z" fill="' + fill + '" stroke="' + ring + '" stroke-width="2.5"/>'
                + '<circle cx="22" cy="18" r="9" fill="#fff"/>'
                + '<rect x="16" y="14" width="12" height="8" rx="1.5" fill="' + fill + '"/>'
                + '<rect x="17" y="15" width="4" height="3" rx=".5" fill="#fff" opacity=".9"/>'
                + '<rect x="23" y="15" width="4" height="3" rx=".5" fill="#fff" opacity=".9"/>'
                + '<rect x="17" y="19" width="10" height="1.5" rx=".5" fill="#fff" opacity=".6"/>'
                + '</svg>';
              return L.divIcon({
                html: svg, className: '', iconSize: [44, 54], iconAnchor: [22, 52], popupAnchor: [0, -50]
              });
            }

            function formatLiveCount(count) {
              return '<span class="dash-live-dot" aria-hidden="true"></span>' + count + ' bus' + (count !== 1 ? 'es' : '') + ' live';
            }

            function fetchBuses() {
              fetch('/B/live', { credentials: 'same-origin', cache: 'no-store' })
                .then(function (r) { return r.json(); })
                .then(function (buses) {
                  if (!Array.isArray(buses)) return;

                  buses = buses.filter(function (b) {
                    var type = String(b.operatorType || '').toLowerCase();
                    var owner = Number(b.ownerId || b.owner_id || 0);
                    return type === 'private' && (!OWNER_ID || owner === OWNER_ID);
                  });

                  var countEl = document.getElementById('bo-live-count');
                  if (countEl) countEl.innerHTML = formatLiveCount(buses.length);

                  var seen = {};
                  buses.forEach(function (b) {
                    if (b.lat == null || b.lng == null) return;
                    seen[b.busId] = true;
                    var speed = b.speedKmh ?? b.speed ?? 0;
                    var busIdEnc = encodeURIComponent(b.busId);
                    var routeNo = b.routeNo ?? b.route_no ?? '-';
                    var stamp = new Date(b.updatedAt || b.snapshotAt || Date.now()).toLocaleTimeString();
                    var popup = '<div class="dash-map-popup">'
                      + '<b>' + b.busId + '</b>'
                      + '<span>Route: <strong>' + routeNo + '</strong></span>'
                      + '<span class="' + (speed > 60 ? 'popup-speed popup-speed--high' : 'popup-speed') + '">' + speed + ' km/h</span>'
                      + (b.owner ? '<small>' + b.owner + '</small>' : '')
                      + '<small>' + stamp + '</small>'
                      + '<a href="/B/fleet?focus=' + busIdEnc + '">View Fleet Profile</a>'
                      + '</div>';

                    if (markers[b.busId]) {
                      markers[b.busId].setLatLng([b.lat, b.lng])
                        .setIcon(busIcon(speed))
                        .bindPopup(popup);
                    } else {
                      markers[b.busId] = L.marker([b.lat, b.lng], { icon: busIcon(speed) })
                        .bindPopup(popup)
                        .addTo(map);
                    }
                  });

                  Object.keys(markers).forEach(function (id) {
                    if (!seen[id]) {
                      map.removeLayer(markers[id]);
                      delete markers[id];
                    }
                  });

                  if (!focusDone) {
                    if (focusBus && markers[focusBus]) {
                      map.setView(markers[focusBus].getLatLng(), 14);
                      markers[focusBus].openPopup();
                      focusDone = true;
                    } else if (Number.isFinite(focusLat) && Number.isFinite(focusLng)) {
                      map.setView([focusLat, focusLng], 14);
                      focusDone = true;
                    }
                  }
                })
                .catch(function () {
                  var countEl = document.getElementById('bo-live-count');
                  if (countEl) countEl.textContent = 'Unavailable';
                });
            }

            fetchBuses();
            setInterval(fetchBuses, 15000);
            setTimeout(function () { map.invalidateSize(); }, 250);
          })();
        </script>
      </div>

      <div class="card owner-dashboard-card dash-recent-card">
        <h3 class="card-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="1" y="7" width="22" height="13" rx="2" />
            <path d="M1 13h22M5 20v2M19 20v2" />
          </svg>
          Recent Buses Added
          <a href="/B/fleet" class="dash-title-link">View all buses &rarr;</a>
        </h3>
        <div class="table-container">
          <table class="data-table dash-recent-table">
            <thead>
              <tr>
                <th>Reg. Number</th>
                <th>Status</th>
                <th aria-label="Open bus"></th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($recent_buses)): ?>
                <?php foreach ($recent_buses as $b):
                  $status = $b['status'] ?? 'Active';
                  $cls = match ($status) {
                    'Maintenance' => 'status-maintenance',
                    'Inactive' => 'status-out',
                    default => 'status-active'
                  };
                  $reg = $b['reg_no'] ?? ($b['bus_number'] ?? '-');
                  ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($reg) ?></strong></td>
                    <td><span class="status-badge <?= $cls ?>"><?= htmlspecialchars($status) ?></span></td>
                    <td class="dash-row-link"><a href="/B/fleet?focus=<?= urlencode((string) $reg) ?>" aria-label="Open bus <?= htmlspecialchars($reg) ?>">&rsaquo;</a></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="dash-empty-row">No buses registered yet.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="owner-dashboard-right">
      <div class="card owner-dashboard-card dash-qa-card">
        <h3 class="card-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8Z" />
          </svg>
          Quick Actions
        </h3>
        <div class="quick-actions-grid">
          <a href="/B/fleet" class="quick-action-btn qa-fleet">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="1" y="7" width="22" height="13" rx="2" />
                <path d="M1 13h22M5 20v2M19 20v2" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Manage Fleet</span>
              <span class="qa-desc">Add or edit buses</span>
            </div>
          </a>
          <a href="/B/drivers" class="quick-action-btn qa-staff">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Staff</span>
              <span class="qa-desc">Manage drivers &amp; conductors</span>
            </div>
          </a>
          <a href="/B/attendance" class="quick-action-btn qa-attendance">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="m16 11 2 2 4-4" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Attendance</span>
              <span class="qa-desc">Mark today's attendance</span>
            </div>
          </a>
          <a href="/B/earnings" class="quick-action-btn qa-earnings">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Earnings</span>
              <span class="qa-desc">Record &amp; view income</span>
            </div>
          </a>
          <a href="/B/performance" class="quick-action-btn qa-perf">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 20V10M12 20V4M6 20v-6" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Performance</span>
              <span class="qa-desc">Analytics &amp; reports</span>
            </div>
          </a>
          <a href="/B/feedback" class="quick-action-btn qa-feedback">
            <div class="qa-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 15a4 4 0 0 1-4 4H7l-4 3V5a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z" />
              </svg>
            </div>
            <div class="qa-text">
              <span class="qa-label">Feedback</span>
              <span class="qa-desc">Passenger complaints</span>
            </div>
          </a>
        </div>
      </div>

      <div class="card owner-dashboard-card dash-status-card">
        <h3 class="card-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
          </svg>
          Fleet Status
        </h3>
        <div class="alerts-list">
          <?php if ($maintBuses > 0): ?>
            <a class="alert-item alert-warning" href="/B/fleet">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM10 6v4M10 14h.01" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" />
              </svg>
              <span class="alert-content">
                <span class="alert-title"><?= $maintBuses ?> bus<?= $maintBuses > 1 ? 'es' : '' ?> under maintenance</span>
                <span class="alert-time">Review in Fleet management</span>
              </span>
              <span class="alert-arrow" aria-hidden="true">&rsaquo;</span>
            </a>
          <?php endif; ?>

          <a class="alert-item alert-success" href="/B/fleet">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
              <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" stroke="currentColor" stroke-width="2" />
              <path d="m7 10 2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <span class="alert-content">
              <span class="alert-title"><?= $activeBuses ?> bus<?= $activeBuses !== 1 ? 'es' : '' ?> operational</span>
              <span class="alert-time"><?= $activePct ?>% of fleet is active</span>
            </span>
            <span class="alert-arrow" aria-hidden="true">&rsaquo;</span>
          </a>

          <?php if ($totalDrivers === 0): ?>
            <a class="alert-item alert-warning" href="/B/drivers">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM10 6v4M10 14h.01" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" />
              </svg>
              <span class="alert-content">
                <span class="alert-title">No drivers registered</span>
                <span class="alert-time">Add drivers in the Staff section</span>
              </span>
              <span class="alert-arrow" aria-hidden="true">&rsaquo;</span>
            </a>
          <?php else: ?>
            <a class="alert-item alert-info" href="/B/drivers">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" stroke="currentColor" stroke-width="2" />
                <path d="M10 8v4M10 14h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span class="alert-content">
                <span class="alert-title"><?= $totalDrivers ?> staff member<?= $totalDrivers !== 1 ? 's' : '' ?> registered</span>
                <span class="alert-time">Manage in Staff section</span>
              </span>
              <span class="alert-arrow" aria-hidden="true">&rsaquo;</span>
            </a>
          <?php endif; ?>

          <a class="alert-item alert-neutral" href="/B/attendance">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
              <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2" />
              <path d="M10 6v4l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="alert-content">
              <span class="alert-title">Today - <?= htmlspecialchars($shortDate) ?></span>
              <span class="alert-time">Mark attendance for today's shifts</span>
            </span>
            <span class="alert-arrow" aria-hidden="true">&rsaquo;</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    function updateTime() {
      var el = document.getElementById('dash-live-time');
      if (!el) return;
      var now = new Date();
      var h = now.getHours().toString().padStart(2, '0');
      var m = now.getMinutes().toString().padStart(2, '0');
      el.textContent = h + ':' + m;
    }
    updateTime();
    setInterval(updateTime, 10000);
  })();
</script>
