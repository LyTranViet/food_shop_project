Vagrant.configure("2") do |config|
  # Box Ubuntu 20.04
  config.vm.box = "ubuntu/focal64"

  # Chia sẻ thư mục code PHP vào /var/www/html trong VM
  config.vm.synced_folder "./src/food_shop_project", "/var/www/html"


  # Map port 8080 trên host → 8080 trong VM (để truy cập PHP app chạy trong Docker)
  config.vm.network "forwarded_port", guest: 8080, host: 8080

  # Cấu hình máy ảo (VirtualBox)
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
    vb.cpus = 2
  end

  # Provision: Cài Docker + Docker Compose
  config.vm.provision "shell", inline: <<-SHELL
    set -e

    # Update hệ thống
    sudo apt-get update -y
    sudo apt-get upgrade -y

    # Gói phụ thuộc
    sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common lsb-release gnupg

    # Add Docker GPG key
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

    # Add Docker repo
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    # Update lại
    sudo apt-get update -y

    # Cài Docker CE + CLI + containerd + plugin compose
    sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

    # Thêm user vagrant vào group docker
    sudo usermod -aG docker vagrant

    # Bật Docker khởi động cùng hệ thống
    sudo systemctl enable docker
    sudo systemctl start docker
  SHELL
end
