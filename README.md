# 📧 Sistem Manajemen Surat Elektronik Multiplatform

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**Aplikasi Web untuk Manajemen Surat Elektronik yang Dapat Diakses Secara Multiplatform**

[Demo](#demo) • [Fitur](#-fitur-unggulan) • [Instalasi](#-instalasi) • [Dokumentasi](#-dokumentasi) • [Kontribusi](#-kontribusi)

</div>

---

## 📖 **Tentang Proyek**

Sistem Manajemen Surat Elektronik adalah aplikasi web modern yang dikembangkan untuk **PT Rifia Sen Tosa** sebagai bagian dari **Kerja Praktek Mahasiswa Teknik Informatika Universitas Bhayangkara Jakarta Raya**. 

Aplikasi ini menggantikan sistem manual pengelolaan surat dengan solusi digital yang terintegrasi, mendukung akses multiplatform (web, mobile, tablet), dan mengotomatisasi workflow surat menyurat perusahaan.

### 👨‍💻 **Developer**
- **Nama**: Bintang Wijaya
- **NPM**: 201910225402
- **Program Studi**: Teknik Informatika
- **Universitas**: Universitas Bhayangkara Jakarta Raya
- **Pembimbing**: Muhamad Khaeruddin, Ir, M.Kom
- **Pembimbing Lapangan**: Abi Hasan

---

## 🚀 **Fitur Unggulan**

### 📱 **Multiplatform Support**
- ✅ **Responsive Web Design** - Akses dari desktop, tablet, mobile
- ✅ **Device Session Tracking** - Monitor akses dari berbagai perangkat
- ✅ **Real-time Online Status** - Lihat user yang sedang online
- ✅ **Cross-platform Notifications** - Notifikasi di semua perangkat

### 📧 **Manajemen Surat Elektronik**
- ✅ **Surat Masuk Digital** - Pencatatan, klasifikasi, dan tracking
- ✅ **Surat Keluar Digital** - Pembuatan, approval workflow, pengiriman
- ✅ **Sistem Disposisi** - Workflow disposisi dengan deadline tracking
- ✅ **Digital Archive** - Pengarsipan otomatis dengan pencarian cepat

### 🔐 **Keamanan & Audit**
- ✅ **Role-based Access Control** - Admin, Pimpinan, Petugas
- ✅ **Digital Signature** - Tanda tangan digital untuk validasi
- ✅ **Activity Logging** - Log semua aktivitas dengan IP tracking
- ✅ **Secure File Upload** - Validasi dan enkripsi file

### ⚡ **Fitur Modern**
- ✅ **Real-time Notifications** - Notifikasi instant dengan prioritas
- ✅ **Email Automation** - Template email dan pengiriman otomatis
- ✅ **Advanced Search** - Pencarian dengan keywords dan filter
- ✅ **Bookmark System** - Simpan surat favorit untuk akses cepat
- ✅ **Dashboard Analytics** - Statistik dan monitoring real-time

---

## 🛠 **Tech Stack**

### **Backend**
- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum
- **Email**: Laravel Mail with SMTP

### **Frontend**
- **CSS Framework**: Bootstrap 5
- **JavaScript**: Vanilla JS + Alpine.js
- **Icons**: Font Awesome 6
- **Charts**: Chart.js
- **Notifications**: Toastr.js

### **DevOps & Tools**
- **Version Control**: Git
- **Dependency Management**: Composer, NPM
- **Development**: XAMPP/Laragon
- **Code Editor**: Visual Studio Code

---

## 📋 **Persyaratan Sistem**

### **Minimum Requirements**
- PHP >= 8.1
- MySQL >= 8.0 atau MariaDB >= 10.3
- Composer >= 2.0
- Node.js >= 16.x
- NPM >= 8.x

### **Recommended**
- PHP 8.2+
- MySQL 8.0+
- 2GB RAM
- 1GB Storage
- SSL Certificate (untuk production)

---

## 🚀 **Instalasi**

### **1. Clone Repository**
```bash
git clone https://github.com/rhecustein/sistem-manajemen-surat.git
cd sistem-manajemen-surat
```

### **2. Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **3. Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **4. Database Configuration**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_surat
DB_rhecustein=root
DB_PASSWORD=
```

### **5. Database Migration & Seeding**
```bash
# Run migrations
php artisan migrate

# Seed initial data
php artisan db:seed

# Or run both at once
php artisan migrate:fresh --seed
```

### **6. Storage Setup**
```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### **7. Build Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

### **8. Start Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 👥 **Default Users**

Setelah seeding, Anda dapat login dengan akun berikut:

| Role | Email | Password | Deskripsi |
|------|--------|----------|-----------|
| Admin | admin@suratapp.com | password123 | Super Administrator |
| Pimpinan | pimpinan@rifia.com | password123 | Direktur/Manager |
| Petugas | bintang@rifia.com | password123 | Staff Administrasi |
| Petugas | siti@rifia.com | password123 | Sekretaris |

---

## 📊 **Database Schema**

### **Tabel Utama**
- `users` - Manajemen pengguna dengan role
- `klasifikasis` - Klasifikasi surat berdasarkan standar kearsipan
- `surat_masuks` - Data surat masuk dengan metadata lengkap
- `surat_keluars` - Data surat keluar dengan approval workflow
- `disposisis` - Sistem disposisi dengan tracking status

### **Tabel Multiplatform**
- `device_sessions` - Tracking akses multiplatform
- `notifications` - Sistem notifikasi real-time
- `attachments` - Manajemen file attachment
- `email_logs` - Log pengiriman email
- `digital_signatures` - Tanda tangan digital

### **Tabel Pendukung**
- `histories` - Log aktivitas sistem
- `bookmarks` - Bookmark surat favorit
- `settings` - Konfigurasi aplikasi
- `kontaks` - Data kontak/mitra
- `email_templates` - Template email otomatis

**📋 [Lihat ERD Lengkap](docs/database-schema.md)**

---

## 🔧 **Konfigurasi**

### **Email Configuration**
Edit file `.env` untuk konfigurasi email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_rhecustein=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourcompany.com
MAIL_FROM_NAME="PT Rifia Sen Tosa"
```

### **File Upload Configuration**
```env
# Maximum file size (in KB)
MAX_FILE_SIZE=10240

# Allowed file extensions
ALLOWED_EXTENSIONS=pdf,doc,docx,xls,xlsx,jpg,jpeg,png

# Upload path
UPLOAD_PATH=public/uploads
```

### **Notification Configuration**
```env
# Enable/disable notifications
NOTIFICATIONS_ENABLED=true
NOTIFICATION_EMAIL=true
NOTIFICATION_DATABASE=true
```

---

## 📱 **Penggunaan**

### **Dashboard Admin**
- Monitor statistik surat masuk/keluar
- Kelola pengguna dan hak akses
- Konfigurasi sistem
- View activity logs

### **Workflow Surat Masuk**
1. **Input Surat** - Petugas mencatat surat masuk
2. **Klasifikasi** - Pilih klasifikasi yang sesuai
3. **Upload File** - Attach dokumen surat
4. **Disposisi** - Pimpinan membuat disposisi
5. **Tindak Lanjut** - Petugas melakukan tindak lanjut
6. **Arsip** - Surat diarsipkan otomatis

### **Workflow Surat Keluar**
1. **Draft** - Petugas membuat draft surat
2. **Review** - Internal review dan edit
3. **Approval** - Pimpinan menyetujui surat
4. **Send** - Surat dikirim ke tujuan
5. **Track** - Monitor status pengiriman
6. **Archive** - Arsip otomatis setelah dikirim

---

## 🧪 **Testing**

### **Run Tests**
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter UserTest

# Run with coverage
php artisan test --coverage
```

### **Factory & Seeding**
```bash
# Generate sample data
php artisan tinker

# In tinker console:
User::factory(10)->create();
SuratMasuk::factory(50)->create();
SuratKeluar::factory(30)->create();
Disposisi::factory(25)->create();
```

---

## 📈 **Performance**

### **Optimization Tips**
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### **Queue Setup (Optional)**
```bash
# Run queue worker
php artisan queue:work

# Process specific queue
php artisan queue:work --queue=emails,notifications
```

---

## 🔒 **Security**

### **Security Features**
- ✅ CSRF Protection
- ✅ SQL Injection Prevention
- ✅ XSS Protection
- ✅ Rate Limiting
- ✅ Input Validation & Sanitization
- ✅ File Upload Security
- ✅ Role-based Access Control

### **Security Checklist**
- [ ] Change default passwords
- [ ] Configure proper file permissions
- [ ] Enable HTTPS in production
- [ ] Set up regular backups
- [ ] Monitor security logs
- [ ] Update dependencies regularly

---

## 📚 **Dokumentasi**

### **API Documentation**
- [Authentication API](docs/api/authentication.md)
- [Surat Masuk API](docs/api/surat-masuk.md)
- [Surat Keluar API](docs/api/surat-keluar.md)
- [Disposisi API](docs/api/disposisi.md)
- [Notifications API](docs/api/notifications.md)

### **User Guides**
- [Panduan Admin](docs/user-guide/admin.md)
- [Panduan Pimpinan](docs/user-guide/pimpinan.md)
- [Panduan Petugas](docs/user-guide/petugas.md)

### **Technical Docs**
- [Database Schema](docs/technical/database.md)
- [Architecture Overview](docs/technical/architecture.md)
- [Deployment Guide](docs/technical/deployment.md)

---

## 🚀 **Deployment**

### **Production Deployment**

#### **1. Server Requirements**
- Ubuntu 20.04+ / CentOS 8+
- Nginx / Apache
- PHP 8.1+ with required extensions
- MySQL 8.0+
- SSL Certificate

#### **2. Environment Setup**
```bash
# Clone repository
git clone https://github.com/rhecustein/sistem-manajemen-surat.git
cd sistem-manajemen-surat

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### **3. Environment Configuration**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=sistem_surat_production
DB_rhecustein=surat_user
DB_PASSWORD=secure_password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server
# ... other mail config
```

#### **4. Optimization**
```bash
# Clear and cache everything
php artisan optimize:clear
php artisan optimize

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Docker Deployment**
```bash
# Build image
docker build -t sistem-surat .

# Run container
docker run -d -p 80:80 --name sistem-surat sistem-surat
```

---

## 🤝 **Kontribusi**

Kami sangat menghargai kontribusi dari komunitas! Berikut cara berkontribusi:

### **Development Setup**
1. Fork repository ini
2. Clone fork Anda
3. Install dependencies
4. Buat branch untuk fitur baru
5. Commit changes Anda
6. Push ke branch
7. Buat Pull Request

### **Coding Standards**
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation
- Follow existing code patterns

### **Bug Reports**
Gunakan [GitHub Issues](../../issues) untuk melaporkan bug dengan template:
- **Environment**: OS, PHP version, Laravel version
- **Steps to reproduce**
- **Expected behavior**
- **Actual behavior**
- **Screenshots** (jika applicable)

---

## 📞 **Support & Contact**

### **Technical Support**
- **Email**: bintang.wijaya@student.ubhara.ac.id
- **WhatsApp**: +62 XXX-XXXX-XXXX
- **GitHub Issues**: [Create Issue](../../issues/new)

### **Business Contact**
- **PT Rifia Sen Tosa**
- **Address**: Jl. Raya Grogol RT 006 RW 001, Kel. Grogol, Kec. Limo, Kota Depok
- **Email**: info@rifia.com

### **Academic Supervisor**
- **Dosen Pembimbing**: Muhamad Khaeruddin, Ir, M.Kom
- **Institution**: Universitas Bhayangkara Jakarta Raya
- **Email**: muhamad.khaeruddin@ubhara.ac.id

---

## 📄 **License**

Proyek ini dilindungi di bawah [MIT License](LICENSE).

```
MIT License

Copyright (c) 2025 Bintang Wijaya - PT Rifia Sen Tosa

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
```

---

## 🙏 **Acknowledgments**

Terima kasih kepada:

- **PT Rifia Sen Tosa** - Kesempatan kerja praktek dan implementasi sistem
- **Universitas Bhayangkara Jakarta Raya** - Bimbingan akademis dan fasilitas
- **Laravel Community** - Framework dan ekosistem yang luar biasa
- **Open Source Contributors** - Libraries dan tools yang digunakan
- **Stack Overflow Community** - Bantuan troubleshooting
- **GitHub** - Platform hosting dan kolaborasi

---

## 📊 **Project Statistics**

![GitHub repo size](https://img.shields.io/github/repo-size/rhecustein/sistem-manajemen-surat)
![GitHub contributors](https://img.shields.io/github/contributors/rhecustein/sistem-manajemen-surat)
![GitHub last commit](https://img.shields.io/github/last-commit/rhecustein/sistem-manajemen-surat)
![GitHub issues](https://img.shields.io/github/issues/rhecustein/sistem-manajemen-surat)
![GitHub pull requests](https://img.shields.io/github/issues-pr/rhecustein/sistem-manajemen-surat)

---

## ⭐ **Star History**

[![Star History Chart](https://api.star-history.com/svg?repos=rhecustein/sistem-manajemen-surat&type=Date)](https://star-history.com/#rhecustein/sistem-manajemen-surat&Date)

---

<div align="center">

**Dibuat dengan ❤️ oleh [Bintang Wijaya](https://github.com/bintangwijaya) untuk PT Rifia Sen Tosa**

[⬆ Back to Top](#-sistem-manajemen-surat-elektronik-multiplatform)

</div>
