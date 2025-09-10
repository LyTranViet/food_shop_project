
Food Shop Project
Đây là ứng dụng web Food Shop được xây dựng bằng PHP và MySQL.
Mục tiêu: quản lý cửa hàng bán đồ ăn, bao gồm các chức năng:

Quản lý sản phẩm

Quản lý khách hàng

Quản lý giỏ hàng và đặt hàng

Thanh toán

🛠 Công nghệ sử dụng

PHP 8.x

MySQL 5.7+

Apache / Nginx

Docker (tùy chọn)
Clone project

## 🚀 Hướng dẫn chạy project với Docker & Vagrant

### Vagrant
- `vagrant up` : Khởi động máy ảo
- `vagrant ssh` : Truy cập vào máy ảo
- `vagrant halt` : Tắt máy ảo
- `vagrant destroy` : Xóa máy ảo

### Docker
- `docker build -t food_shop .` : Build image từ Dockerfile
- `docker run -d -p 8080:80 food_shop` : Chạy project trên port 8080
- `docker ps` : Xem container đang chạy
- `docker exec -it <container_id> bash` : Vào container
- `docker-compose up -d` : Chạy nhiều service
## Setup Instructions
1. **Clone the Repository**: 
   ```bash
   git clone <repository-url>
   cd food-admin-app
   ```

2. **Database Configuration**: 
   - Update the `db.php` file with your database connection details.

3. **Run the Application**: 
   - Use a local server environment (like XAMPP or MAMP) to run the application.
   - Access the application via `http://localhost/food-admin-app/src/index.php`.

## Usage
- Navigate to the login page to access the admin functionalities.
- Use the provided forms to manage food items effectively.

## License
This project is open-source and available for modification and distribution under the MIT License.
# --- VAGRANT ---
vagrant up
vagrant ssh

# --- TRONG VM ---
sudo apt update && sudo apt upgrade -y
sudo apt install docker.io docker-compose -y
sudo systemctl enable docker
sudo systemctl start docker
sudo usermod -aG docker vagrant
exit

# --- SSH LẠI ---
vagrant ssh
cd /vagrant   # vào thư mục project

# --- DOCKER ---
docker --version
docker compose version
docker compose down
# build và chạy container
docker compose up -d

# kiểm tra container
docker ps -a

# xem log database
docker logs -f vagrant-db-1

# truy cập MySQL bên trong container
docker exec -it vagrant-db-1 mysql -uuser -ppass

# dừng và xóa container khi cần
docker compose down