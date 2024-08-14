TMS_SEAL

TMS_SEAL adalah sebuah aplikasi manajemen tugas sederhana yang menggunakan API untuk mengelola proyek, tugas, dan pengguna. Aplikasi ini dibuat dengan PHP dan berjalan pada server lokal.

PERSYARATAN

PHP 7.4 atau lebih baru, 
Composer (untuk mengelola dependensi), 
MySQL atau database lain yang didukung PDO

INSTALASI

Clone repositori ini:
git clone https://github.com/username/TMS_SEAL.git ->
cd TMS_SEAL

Instal dependensi menggunakan Composer:
composer install


KONFIGURASI DATABASE

Buat sebuah database di MySQL dan import file SQL yang disediakan (task_management.sql) ke dalam database tersebut.

Buka file db.php dan sesuaikan konfigurasi database Anda:
$dbname = "task_management";
$host = "localhost";
$uname = "root";
$pass = "";

MENJALANKAN SERVER

Untuk menjalankan server lokal, gunakan perintah berikut:
php -S localhost:8000, 
Server ini akan berjalan pada port 8000. Anda dapat mengakses API melalui URL http://localhost:8000.

STRUKTUR URL API

API yang disediakan oleh aplikasi ini diatur di dalam file index.php. Berikut adalah beberapa endpoint yang tersedia:

Autentikasi:
POST /login - Login pengguna.

Proyek:
GET /projects - Mendapatkan semua proyek.
POST /project - Menambahkan proyek baru.
PUT /project - Memperbarui proyek yang ada.
DELETE /project - Menghapus proyek.

Tugas:
GET /tasks - Mendapatkan semua tugas.
POST /task - Menambahkan tugas baru.
PUT /task - Memperbarui tugas yang ada.
DELETE /task - Menghapus tugas.

Pengguna:
GET /userdetails - Mendapatkan detail pengguna.
POST /register - Registrasi pengguna baru.
PUT /user - Memperbarui informasi pengguna.
DELETE /user - Menghapus pengguna.

PENGUJIAN API

Anda dapat menguji API menggunakan alat seperti Postman atau cURL. Pastikan untuk menyertakan token autentikasi di header permintaan saat mengakses endpoint yang memerlukan autentikasi.
