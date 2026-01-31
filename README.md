1. Yêu cầu hệ thống
- Windows 10 hoặc Windows 11
- XAMPP phiên bản 8.1 trở lên
- PHP 8.1 trở lên
- SQL Server 2019 hoặc SQL Server 2022
- SQL Server Management Studio
- Composer
2. Cài đặt driver SQL Server cho PHP
Tải driver SQL Server cho PHP 8.1 từ trang Microsoft
2.1.	Chọn đúng phiên bản PHP Thread Safe và x64
2.2.	Copy hai file:
-	php_sqlsrv_81_ts_x64.dll
-	php_pdo_sqlsrv_81_ts_x64.dll
2.3.	C:\xampp\php\php.ini
-	Thêm các dòng sau:
-	extension=sqlsrv
-	extension=pdo_sqlsrv

3. Tạo database trên SQL Server
3.1.	Mở SQL Server Management Studio
3.2.	Tạo database: laravel
3.3.	Import file SQL.
4. Clone hoặc copy source code
4.1.	Copy source vào thư mục: C:\xampp\htdocs
4.2.	C:\xampp\htdocs\laravel-project
5. Cấu hình file .env
5.1.	Copy file:
-	.env.example thành .env
5.2.	Cấu hình kết nối SQL Server:
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=laravel
DB_USERNAME=sa
DB_PASSWORD=mật_khẩu_sql
Nếu dùng Windows Authentication thì để trống DB_USERNAME và DB_PASSWORD.

6. Cài đặt Composer
6.1.	Tải Composer tại trang https://getcomposer.org
6.2.	Cài đặt Composer trên máy tính
6.3.	Kiểm tra cài đặt:
6.4.	composer -v
6.7. Cài thư viện và khởi tạo project
7.1. Mở Command Prompt tại thư mục project:
-	composer install
7.2. Tạo khóa ứng dụng:
- php artisan key:generate
8. Chạy project
- php artisan serve
9. Truy cập website:
- http://localhost:8000 / http://127.0.0.1/8000
