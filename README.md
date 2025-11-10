<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Smart_OLT
# 🌐 Smart OLT Monitoring System

**Smart OLT** adalah platform berbasis Laravel dan Python yang dirancang untuk memantau, mengelola, dan menganalisis perangkat **ZTE OLT (Optical Line Terminal)** secara realtime.  
Aplikasi ini cocok digunakan oleh penyedia layanan internet (ISP) untuk memonitor status pelanggan, power optik, serta kondisi koneksi secara efisien melalui antarmuka web yang modern.

---

## ⚙️ Tech Stack
| Layer | Teknologi |
|-------|------------|
| Backend | Laravel 12 (PHP 8.2), MySQL |
| Frontend | TailwindCSS, Alpine.js, Chart.js |
| SNMP Service | Python (PySNMP, SQLAlchemy) |
| Deployment | aaPanel + Nginx |
| Supported OLT | ZTE C300 |

---

## 🚀 Features / Fitur Utama
### 🇮🇩 Bahasa Indonesia
- 🔍 **Monitoring Realtime**: Menampilkan status ONU (Online, Offline, LOS, Dying Gasp) secara langsung.  
- ⚡ **Deteksi Power Optik**: Menampilkan nilai Rx/Tx Power serta jarak pelanggan.  
- 🧠 **Integrasi SNMP Otomatis**: Python mengumpulkan data melalui OID dan menyimpannya ke database Laravel.  
- 🗂️ **Manajemen Data Pelanggan**: CRUD pelanggan, OLT, board, PON, dan ONU ID.  
- 📊 **Dashboard Interaktif**: Statistik pengguna aktif, trafik data, dan kondisi jaringan.  
- 🌐 **Multi-OLT Ready**: Dapat digunakan untuk lebih dari satu perangkat OLT dalam satu sistem.  

### 🇬🇧 English
- 🔍 **Realtime Monitoring**: Live ONU status (Online, Offline, LOS, Dying Gasp).  
- ⚡ **Optical Power Detection**: Displays Rx/Tx Power and ONU distance.  
- 🧠 **Automated SNMP Integration**: Python script fetches OID data and stores it in the Laravel database.  
- 🗂️ **Customer Data Management**: CRUD for customers, OLTs, boards, PONs, and ONU IDs.  
- 📊 **Interactive Dashboard**: Visual charts for active users, traffic, and network health.  
- 🌐 **Multi-OLT Support**: Manage multiple OLTs within one unified dashboard.

---

## 🧩 System Architecture
+-------------------------+
| Web UI | ← TailwindCSS, Alpine.js, Chart.js
+-----------+-------------+
|
v
+-----------+-------------+
| Laravel Backend API | ← MySQL, Controllers, Models, Routes
+-----------+-------------+
|
v
+-----------+-------------+
| Python SNMP Collector | ← PySNMP, Scheduler, SQLAlchemy
+-----------+-------------+
|
v
+-----------+-------------+
| OLT Device (ZTE C300) |
+-------------------------+

yaml
Salin kode

---

## 🛠️ Installation / Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Shinee33/Smart_OLT.git
cd Smart_OLT
2. Install Dependencies
bash
Salin kode
composer install
npm install && npm run build
3. Konfigurasi .env
Sesuaikan koneksi database dan mail:

env
Salin kode
APP_NAME="Smart OLT"
APP_URL=http://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=smart_olt
DB_USERNAME=root
DB_PASSWORD=yourpassword
4. Generate Key dan Migrasi Database
bash
Salin kode
php artisan key:generate
php artisan migrate
php artisan db:seed
5. Jalankan Server Laravel
bash
Salin kode
php artisan serve
Akses di:
👉 http://localhost:8000

🐍 Python SNMP Service Setup
1. Masuk folder py/
bash
Salin kode
cd py
2. Install Requirements
bash
Salin kode
pip install -r requirements.txt
3. Jalankan Script SNMP
bash
Salin kode
python olt_snmp.py
Script ini otomatis menarik data OLT (ZTE C300) seperti:

Rx/Tx Power

ONU Online/Offline

Distance

Uptime


🔒 Security
Pastikan APP_ENV=production dan APP_DEBUG=false di server produksi.

Gunakan SSL dari Cloudflare atau Let’s Encrypt.

Batasi akses SNMP pada IP tertentu untuk keamanan jaringan.

🤝 Kontribusi / Contribution
Pull requests are welcome!
Untuk perbaikan bug, ide fitur baru, atau optimasi SNMP, silakan buka issue terlebih dahulu.

🧾 License
MIT License
Copyright (c) 2025 Shinee

📧 Contact
Developer: Shinee
Email: alvito06widianto@gmail.com
GitHub: https://github.com/Shinee33
