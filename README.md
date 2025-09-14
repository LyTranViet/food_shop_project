<<<<<<< HEAD

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
=======
# food_shop_project
Bước 1: Chuẩn bị EC2

Kết nối SSH vào EC2

Mở PowerShell hoặc terminal:
powershellssh -i E:\DEVOPS\food-shop-key.pem ubuntu@3.0.52.17

Xác nhận: Thấy prompt ubuntu@ip-172-31-xx-xx:~$.


Cài Git trên EC2

Chạy:
bashsudo apt update
sudo apt install -y git

Xác nhận: Kiểm tra:
bashgit --version

Nên thấy phiên bản (ví dụ: git version 2.25.1).




Cấu hình Git trên EC2

Đặt thông tin:
bashgit config --global user.name "Your Name"
git config --global user.email "your_email@example.com"

Xác nhận: Kiểm tra:
bashgit config --global user.name
git config --global user.email




Bước 2: Clone dự án từ GitHub

Clone repository

Chạy:
bashcd ~


Xác nhận: Kiểm tra:
bashls -l ~/food-shop-project

Nên thấy các file như docker-compose.yml, src, mysql_init.


cài các paccle
# 1. Update package index
sudo apt-get update

# 2. Cài gói hỗ trợ
sudo apt-get install -y ca-certificates curl gnupg lsb-release

# 3. Thêm Docker GPG key
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
  sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

# 4. Thêm Docker repository
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# 5. Cập nhật lại apt và cài Docker CE + plugin Compose + Buildx
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
docker ps -a
# 1. Thêm user ubuntu vào group docker
sudo usermod -aG docker $USER

# 2. Tải lại group mà không cần logout
newgrp docker


Di chuyển vào thư mục dự án

Chạy:
bashcd ~/food-shop-project

Xác nhận: Kiểm tra:
bashls -l




Bước 3: Cấu hình và chạy Docker Compose

Sửa docker-compose.yml (nếu cần)

Mở file:
bashnano docker-compose.yml

Đảm bảo nội dung:
yamlservices:
  php_app:
    build: .
    container_name: php_app
    ports:
      - "8080:80"
    volumes:
      - ./src/food_shop_project:/var/www/html
    depends_on:
      - mysql_db
  mysql_db:
    image: mysql:5.7
    container_name: mysql_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: food_shop
      MYSQL_USER: fooduser
      MYSQL_PASSWORD: 123456
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./mysql_init:/docker-entrypoint-initdb.d
volumes:
  db_data:

Xóa dòng version: "3.3" nếu có, rồi lưu (Ctrl+O, Enter, Ctrl+X).
Xác nhận: Kiểm tra:
bashcat docker-compose.yml



Chạy Docker Compose

Chạy:
bashdocker compose up -d --build

Xác nhận: Kiểm tra:
bashdocker ps -a

Nên thấy container php_app (port 8080->80) và mysql_db (port 3306->3306) ở trạng thái Up.




Kiểm tra log

Chạy:
bashdocker logs php_app
docker logs mysql_db

Xác nhận: Log php_app hiển thị Apache chạy (AH00163: Apache/2.4.65 configured), log mysql_db có mysqld: ready for connections.



Bước 4: Kiểm tra truy cập web

Truy cập từ máy local

Mở trình duyệt: http://3.0.52.17:8080.
Hoặc dùng curl:
powershellcurl -v http://3.0.52.17:8080

Xác nhận: Nếu thấy giao diện web hoặc mã HTML, web chạy. Nếu lỗi Connection timed out, kiểm tra Security Group.


Kiểm tra từ EC2

Chạy:
bashcurl -v http://localhost:8080

Xác nhận: Trả về nội dung web (HTML).


Kiểm tra Security Group (nếu lỗi)

AWS Console > EC2 > Instances > Chọn food-shop-vm > Security > Security Groups > Edit inbound rules.
Đảm bảo:

Port 8080, Source: 0.0.0.0/0.


Thêm nếu thiếu, thử lại http://3.0.52.17:8080.



Bước 5: Thêm CI/CD (tùy chọn, nếu muốn tự động hóa)
Nếu bạn muốn tự động deploy từ GitHub, làm theo các bước sau:

Cập nhật docker-compose.yml cho CD

Sửa để dùng image từ Docker Hub (sau này sẽ build và push):
bashnano docker-compose.yml

Cập nhật:
yamlservices:
  php_app:
    image: <username>/food-shop-project:php-app-latest
    container_name: php_app
    ports:
      - "8080:80"
    volumes:
      - ./src/food_shop_project:/var/www/html
    depends_on:
      - mysql_db
  mysql_db:
    image: mysql:5.7
    container_name: mysql_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: food_shop
      MYSQL_USER: fooduser
      MYSQL_PASSWORD: 123456
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./mysql_init:/docker-entrypoint-initdb.d
volumes:
  db_data:



Lưu.


Cấu hình GitHub Actions

Tạo file .github/workflows/ci-cd.yml trên local:
powershellcd E:\food_shop_project-main
mkdir -p .github\workflows
notepad .github\workflows\ci-cd.yml

Dán:
yamlname: CI/CD Pipeline

on:
  push:
    branches:
      - main

jobs:
  build-and-push:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout code
        uses: actions/checkout@v3

      - name: Set up Docker Buildx
        uses: docker/setup-buildx-action@v2

      - name: Log in to Docker Hub
        uses: docker/login-action@v2
        with:
          username: ${{ secrets.DOCKER_USERNAME }}
          password: ${{ secrets.DOCKER_PASSWORD }}

      - name: Build and push Docker image
        run: |
          docker build -t <username>/food-shop-project:php-app-${{ github.run_number }} .
          docker push <username>/food-shop-project:php-app-${{ github.run_number }}

      - name: Deploy to EC2
        uses: appleboy/ssh-action@v0.1.10
        with:
          host: ${{ secrets.SERVER_HOST }}
          username: ${{ secrets.SERVER_USER }}
          key: ${{ secrets.SERVER_SSH_KEY }}
          script: |
            cd ~/food-shop-project
            docker compose pull
            docker compose up -d

Commit và push:
powershellgit add .github/workflows/ci-cd.yml
git commit -m "Add CI/CD"
git push origin main



Thêm Secrets

GitHub > Repository > Settings > Secrets and variables > Actions > Secrets.
Thêm:

DOCKER_USERNAME: Tên Docker Hub.
DOCKER_PASSWORD: Token Docker Hub.
SERVER_HOST: 3.0.52.17.
SERVER_USER: ubuntu.
SERVER_SSH_KEY: Nội dung private key (tạo trên EC2: cat ~/.ssh/id_rsa).




Kiểm tra CI/CD

Push code:
powershellgit add .
git commit -m "Test deploy"
git push origin main

Xác nhận: Vào GitHub > Actions, xem workflow chạy. Trên EC2:
bashdocker ps -a
docker logs php_app

Container dùng image mới, web chạy tại http://3.0.52.17:8080.
