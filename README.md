<div align="center">

<img src="public/assets/images/logo.png" alt="NexBus logo" width="96" />

# NexBus: Smart Bus Tracking & Fleet Management Platform

**A role-based web platform that digitises Sri Lanka's public and private bus operations, from live GPS tracking to fleet, staff, revenue and performance analytics.**

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL%20%2F%20MariaDB-30%20tables-4479A1?logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?logo=javascript&logoColor=black)
![Leaflet](https://img.shields.io/badge/Leaflet-1.9-199900?logo=leaflet&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.4-FF6384?logo=chartdotjs&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-Custom%20MVC-8B1E3F)
![Roles](https://img.shields.io/badge/User%20roles-7-F3B944)

<img src="docs/screenshots/hero-showcase.webp" alt="NexBus showcase: Bus Owner earnings dashboard and passenger live map on a map of Sri Lanka" width="900" />

<sub><i>The Bus Owner Portal: the module I led, redesigned and built most of.</i></sub>

</div>

---

## 📌 At a Glance

| | |
|---|---|
| **What it is** | A full-stack web platform for the National Transport Commission (NTC), SLTB depots, private bus owners, timekeepers and passengers |
| **Problem solved** | Bus operations in Sri Lanka still run on paper logs, phone calls and spreadsheets, so nobody has a live view of where buses are or how the fleet is performing |
| **Scale of the system** | 7 user roles · 95 routes/endpoints · 30 relational tables · **36,000+ GPS snapshots** · 170 buses (62 private + 108 SLTB) · 60 routes |
| **Team** | 4 developers working through Git and GitHub with a shared custom MVC framework |
| **My role** | **Lead developer of the Private Bus Owner module**: database migrations, backend, frontend and UI/UX across all 8 pages, plus fixes in shared modules |
| **My footprint** | 60+ commits · **~80% of the owner module's current code** (≈14,800 of 18,600 lines by `git blame`) across its controller, 9 models, 9 views, CSS and JS |

---

## 👨‍💻 My Contribution: The Private Bus Owner Portal

I led the **Private Bus Owner** role. It's the part of NexBus that a private bus company uses to run its business every day. A teammate set up the first scaffold. I then rebuilt and extended it into the current module: the database migrations, controller logic, models, views, client-side JavaScript and the complete visual redesign.

### What I built

| Page | What it does | Engineering highlights |
|---|---|---|
| **🏠 Dashboard** | Greeting hero, fleet KPIs, a live map of the owner's buses, quick actions and fleet status alerts | Live Leaflet map that refreshes every 15 s from an **owner-scoped JSON API** I wrote (`/B/live`) |
| **🚌 Fleet Management** | Add, edit and delete buses; assign drivers and conductors; filter by route, class, age and assignment | Assignment is **locked automatically** when a bus goes to *Maintenance* or *Out of Service*, and the assigned staff are released. Deletes run inside a **PDO transaction** that cascades through trips, assignments, timetables and earnings |
| **👥 Staff (Drivers & Conductors)** | Separate registries with profiles, status (Active/Suspended) and KPI cards | Every status change is written to an **audit table** (`private_staff_status_logs`) with the old status, new status, reason and timestamp |
| **✅ Attendance** | Mark daily attendance (Present, Absent, Late, Half Day) for all staff, with history and per-person filters | Suspended staff are locked out of marking. Bulk save uses an upsert, and summary rates are computed over 30 days |
| **💰 Earnings & Expenses** | Record income per bus, view the revenue trend and income by route, export reports | Chart.js line and doughnut charts, redesigned earnings table and data fetching, CSV report export. Ownership is checked before every write |
| **📊 Performance Analytics** | Live KPIs (delayed buses, driver rating, speed violations, long waits), live fleet speed, analytics charts and a fleet table | Drill-down modals for each KPI, plus a **composite reliability score** I designed (see below) |
| **💬 Feedback** | Passenger complaints and feedback for the owner's buses, with status workflow and replies | Filter by status and type, search, and track resolved vs. pending |
| **👤 Profile** | Update details, change password, delete account | Password hashing and verification |

### Technical decisions I'm proud of

- **Multi-tenant data isolation.** Every query in the owner module is scoped to the logged-in operator's `private_operator_id`, so one bus company can never read or change another company's buses, staff, earnings or GPS data. Ownership is checked again before each update or delete, not just when the page loads.
- **A composite driver reliability score (0–10).** Raw GPS data doesn't tell you who is a "good" driver, so I wrote a SQL scoring expression that blends three signals:

  ```text
  score = 0.45 × on-time score  +  0.35 × (100 − 6 × avg delay minutes)  +  0.20 × (100 − 100 × speed violations)
  ```

  It falls back gracefully when a stored `reliability_index` is missing, which keeps the KPI meaningful for buses that only have live snapshots.
- **Business rules in the data layer.** For example, a bus in maintenance can't be assigned a driver. The rule is enforced in the SQL `UPDATE ... WHERE status NOT IN ('Maintenance','Inactive')` itself, so the UI can't bypass it.
- **Validation in layers.** Validation runs in modal forms on the client side, backed by a fluent server-side `Validator` (`required()->integer()->...`) for name formats, licence numbers, phone numbers and registration numbers.
- **UI/UX redesign.** I redesigned the whole portal (sidebar, hero banners, KPI cards, empty states and responsive grids) into a consistent design system scoped with CSS so the other modules weren't affected.

---

## 🖼️ Screenshots

### Private Bus Owner Portal (my module)

<table>
  <tr>
    <td width="50%"><img src="docs/screenshots/owner-dashboard.webp" alt="Owner dashboard" /><br/><b>Dashboard</b>: KPIs, live fleet tracker and fleet status</td>
    <td width="50%"><img src="docs/screenshots/owner-fleet.webp" alt="Fleet management" /><br/><b>Fleet Management</b>: status, assignment locks and live location per bus</td>
  </tr>
  <tr>
    <td><img src="docs/screenshots/owner-performance.webp" alt="Performance dashboard" /><br/><b>Performance</b>: real-time KPIs and live fleet speed against the 60 km/h limit</td>
    <td><img src="docs/screenshots/owner-analytics.webp" alt="Performance analytics charts" /><br/><b>Analytics Charts</b>: bus status, delays by route, revenue and wait times</td>
  </tr>
  <tr>
    <td><img src="docs/screenshots/owner-staff.webp" alt="Drivers and conductors" /><br/><b>Drivers & Conductors</b>: staff registry with status and audit trail</td>
    <td><img src="docs/screenshots/owner-attendance.webp" alt="Staff attendance" /><br/><b>Attendance</b>: daily marking, with suspended staff locked out</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><img src="docs/screenshots/owner-earnings.webp" alt="Earnings and expenses" width="70%" /><br/><b>Earnings & Expenses</b>: revenue trend, income by route and CSV export</td>
  </tr>
</table>

### Other parts of the platform (team modules)

<table>
  <tr>
    <td width="36%" align="center"><img src="docs/screenshots/passenger-live-map.webp" alt="Passenger live map" width="280" /><br/><b>Passenger app (mobile)</b>: live map and next-bus ETA</td>
    <td width="64%">
      <img src="docs/screenshots/admin-dashboard.webp" alt="NTC admin dashboard" /><br/><b>NTC Admin</b>: nationwide view of 170 buses, depots and routes<br/><br/>
      <img src="docs/screenshots/manager-dashboard.webp" alt="Depot manager dashboard" /><br/><b>SLTB Depot Manager</b>: depot fleet, staff and live tracking
    </td>
  </tr>
</table>

---

## 🏗️ System Architecture

NexBus runs on a **custom-built MVC framework**. There's no Laravel or Symfony underneath, so the team wrote its own front controller, router, autoloader, middleware and base classes.

```mermaid
flowchart TB
    subgraph Clients
        P["📱 Passenger<br/>(mobile web)"]
        S["🖥️ Staff portals<br/>Admin · Depot · Owner · Timekeepers"]
    end

    subgraph Server["PHP 8 application"]
        FC["public/index.php<br/>Front controller + router"]
        MW["AuthMiddleware<br/>session + role guard"]
        C["Controllers<br/>(one per role)"]
        M["Models<br/>(PDO, prepared statements)"]
        V["Views + Layouts<br/>(per-role templates)"]
        LB["LiveBusesController<br/>GPS ingestion API"]
    end

    DB[("MySQL / MariaDB<br/>30 tables")]
    GPS["🛰️ External live-bus<br/>GPS feed"]

    P & S -->|HTTP / AJAX| FC --> MW --> C
    C --> M --> DB
    C --> V -->|HTML| Clients
    GPS -->|JSON every few s| LB --> DB
    S -.->|"poll /B/live every 15 s"| C
```

### Request lifecycle

```mermaid
sequenceDiagram
    autonumber
    participant B as Browser
    participant I as index.php (router)
    participant A as AuthMiddleware
    participant C as BusOwnerController
    participant M as BusModel
    participant D as MySQL

    B->>I: GET /B/fleet
    I->>I: Bootstrap (.env, config, PDO, secure session)
    I->>A: requireRole(['PrivateBusOwner'])
    A-->>I: ✅ authorised (otherwise redirect to the role's home)
    I->>C: fleet()
    C->>M: all()
    M->>D: SELECT … WHERE private_operator_id = :op
    D-->>M: rows (this owner's buses only)
    M-->>C: buses + drivers + conductors
    C-->>B: render views/bus_owner/fleet.php inside the owner layout
```

### Live GPS tracking pipeline

The team built the shared ingestion layer. I built the owner-scoped feed (`/B/live`) and the dashboard map and Performance KPIs that consume it.

```mermaid
flowchart TD
    A["🛰️ External GPS API<br/>busId · lat/lng · speed · heading"] -->|"fetch, 10 s file cache,<br/>fallback URLs"| B["LiveBusesController::proxy()"]
    B --> C{"Bus known<br/>in DB?"}
    C -- No --> D["Auto-register bus"]
    C -- Yes --> E["Enrich with operator,<br/>depot, owner and route"]
    D --> E
    E --> F["Derive metrics<br/>• speed over 60 km/h → violation<br/>• stationary time → wait minutes<br/>• delayed trip → status"]
    F -->|"throttled: 1 snapshot<br/>per bus per minute"| G[("tracking_monitoring<br/>36k+ snapshots")]
    G --> H["/B/live: owner-scoped feed"]
    G --> I["/api/buses/live: public feed"]
    H --> J["Owner dashboard map<br/>+ Performance KPIs"]
    I --> K["Passenger map · Admin · Depot views"]
```

---

## 🗄️ Database Design (core entities of the Bus Owner module)

```mermaid
erDiagram
    PRIVATE_BUS_OWNERS ||--o{ PRIVATE_BUSES : owns
    PRIVATE_BUS_OWNERS ||--o{ PRIVATE_DRIVERS : employs
    PRIVATE_BUS_OWNERS ||--o{ PRIVATE_CONDUCTORS : employs
    PRIVATE_BUS_OWNERS ||--o{ USERS : "owner accounts"
    PRIVATE_BUSES }o--o| PRIVATE_DRIVERS : "assigned driver"
    PRIVATE_BUSES }o--o| PRIVATE_CONDUCTORS : "assigned conductor"
    PRIVATE_BUSES ||--o{ PRIVATE_TRIPS : runs
    PRIVATE_BUSES ||--o{ EARNINGS : generates
    PRIVATE_BUSES ||--o{ TRACKING_MONITORING : "GPS snapshots"
    PRIVATE_BUSES ||--o{ COMPLAINTS : receives
    ROUTES ||--o{ PRIVATE_TRIPS : on
    PRIVATE_DRIVERS ||--o{ PRIVATE_STAFF_ATTENDANCE : "marked daily"
    PRIVATE_DRIVERS ||--o{ PRIVATE_STAFF_STATUS_LOGS : "status history"

    PRIVATE_BUSES {
        string reg_no PK
        int private_operator_id FK
        string model
        string bus_class
        int capacity
        string status
        int driver_id FK
        int conductor_id FK
    }
    TRACKING_MONITORING {
        int id PK
        string bus_reg_no FK
        datetime snapshot_at
        decimal lat
        decimal lng
        decimal speed
        string operational_status
        int speed_violations
        decimal avg_delay_min
    }
    PRIVATE_STAFF_ATTENDANCE {
        int id PK
        int operator_id FK
        enum staff_type
        int staff_id
        date work_date
        enum status
    }
```

The full schema has **30 tables** covering SLTB depots, timetables, fares, assignments, trips, direct messaging, notifications and passenger favourites. I wrote the owner-module migrations in [`database/migrations`](database/migrations), including staff attendance, staff status logs and bus profile fields.

---

## 👥 User Roles

```mermaid
flowchart TB
    NTC["🏛️ NTC Admin<br/>routes · fares · timetables · users · analytics"]
    DM["🏢 SLTB Depot Manager<br/>depot fleet · staff · performance · earnings"]
    DO["📋 SLTB Depot Officer<br/>assignments · attendance · trip logs · messaging"]
    TS["⏱️ SLTB Timekeeper<br/>trip entries · departures/arrivals"]
    BO["🚌 Private Bus Owner ⭐<br/>fleet · staff · attendance · earnings · performance · feedback"]
    TP["⏱️ Private Timekeeper<br/>private trip entries"]
    PX["📱 Passenger<br/>live map · timetable · fares · favourites · feedback"]

    NTC --> DM --> DO --> TS
    NTC --> BO --> TP
    NTC -.-> PX
```

<sub>⭐ = the module I built.</sub>

Access is enforced centrally. Every URL prefix (`/A`, `/M`, `/O`, `/B`, `/TP`, `/TS`) maps to an allowed role in the front controller, and anyone without that role is redirected to their own home page.

---

## 🔐 Security & Quality Practices

- **SQL injection protection.** All queries use PDO prepared statements with `ATTR_EMULATE_PREPARES = false`.
- **Session hardening.** Sessions use strict mode, `HttpOnly` and `SameSite=Lax` cookies, `Secure` over HTTPS, and `session_regenerate_id()` at login.
- **Passwords.** Passwords are stored as `password_hash()` and checked with `password_verify()`.
- **Role-based access control.** The middleware checks the role on every request, and each controller guards itself again with `requireLogin([...])`.
- **Tenant isolation.** Owner-scoped queries and ownership checks run before writes (see above).
- **CSRF protection.** Tokens protect the timekeeper trip-entry forms.
- **Output escaping.** Views escape output with `htmlspecialchars`.
- **Operational logging.** Errors go to daily log files in `logs/`.

---

## 🛠️ Tech Stack

| Layer | Technologies |
|---|---|
| **Backend** | PHP 8.2 (strict types, namespaces, PSR-4-style autoloader), custom MVC, PDO |
| **Database** | MySQL / MariaDB, SQL migrations, seed scripts |
| **Frontend** | HTML5, CSS3 (custom design system, responsive grid), vanilla JavaScript, AJAX/Fetch |
| **Maps & charts** | Leaflet 1.9 + OpenStreetMap, Chart.js 4 |
| **Real-time** | GPS polling API, Server-Sent Events for depot messaging |
| **Tooling** | Git & GitHub (multi-developer workflow), XAMPP, phpMyAdmin, VS Code |

---

## 📂 Project Structure

```text
NexBus/
├── public/            # Front controller (index.php), CSS, JS, images
│   └── assets/js/analytics/   # Chart.js and Leaflet modules (live fleet, revenue, delays…)
├── bootstrap/         # App bootstrap (env, config, PDO, session) + autoloader
├── config/            # App and database config (read from .env)
├── Middleware/        # AuthMiddleware: login + role guard
├── Support/           # Env loader, fluent Validator, DepotLocator
├── controllers/       # One controller per role + LiveBusesController (GPS API)
├── models/            # Per-role model folders (bus_owner/, depot_manager/, …)
├── views/             # Per-role views + Layouts/
├── database/          # Full DB dump + migrations
├── scripts/           # Seeding, diagnostics and migration helpers
└── docs/screenshots/  # README images
```

---

## 🚀 Run It Locally

**Requirements:** PHP 8.1+ and MySQL/MariaDB (XAMPP works out of the box).

1. **Clone the repository**
   ```bash
   git clone https://github.com/gayashan-indrasankha/NexBus.git
   ```
2. **Create the database.** Create a database named `nexbus` and import `database/CompletedDB.sql` with phpMyAdmin (the dump is UTF-16 encoded, which phpMyAdmin detects automatically).
3. **Configure the environment.** Set your `DB_*` values in `.env`.
4. **Start the server** from the project root:
   ```bash
   php -S localhost:8000 -t public
   ```
5. **Open the app** at `http://localhost:8000/login` and sign in with a seeded account for the role you want to explore.

---

## 🤝 Team

NexBus was built by a team of four developers. Each of us owned one or more user roles, and we all shared the core framework.

| Developer | Focus |
|---|---|
| **[Gayashan Indrasankha](https://github.com/gayashan-indrasankha)** | **Private Bus Owner portal**: fleet, staff, attendance, earnings, performance analytics, feedback and UI redesign |
| [Yomal Kannangara](https://github.com/yomalkannangara) | Core framework and folder structure, NTC Admin, live GPS ingestion, initial module scaffolds |
| [ShamuHe](https://github.com/ShamuHe) | SLTB Depot Officer and SLTB/Private Timekeeper modules |
| [Pasindu Dhanushka](https://github.com/Pasindu-Dhanushka) | SLTB Depot Manager module |

---

<div align="center">

### 📫 Let's connect

**Gayashan Indrasankha** · Full-Stack Developer

[![GitHub](https://img.shields.io/badge/GitHub-gayashan--indrasankha-181717?logo=github)](https://github.com/gayashan-indrasankha)
[![Email](https://img.shields.io/badge/Email-gayashanindrasankha%40gmail.com-EA4335?logo=gmail&logoColor=white)](mailto:gayashanindrasankha@gmail.com)

<sub>If this project interests you, I'd be happy to walk you through the code, the architecture decisions or a live demo.</sub>

</div>
