# Hướng dẫn Docker - CongNgheMoi

## 1. Yêu cầu
- Docker Desktop đã cài đặt
- Tài khoản Docker Hub (nếu muốn push image)

## 2. Build và chạy local

### Build image
```bash
docker-compose build --no-cache
```

### Chạy containers
```bash
docker-compose up -d
```

### Dừng containers
```bash
docker-compose down
```

### Xem logs
```bash
docker-compose logs -f
```

## 3. Truy cập ứng dụng
- **App**: http://localhost:8080/CongNgheMoi
- **phpMyAdmin**: http://localhost:8081
- **MySQL**: localhost:3307

## 4. Push lên Docker Hub

### Đăng nhập
```bash
docker login
```

### Tag image
```bash
docker tag congnghemoi-app:latest ngobao14/congnghemoi-app:latest
```

### Push
```bash
docker push ngobao14/congnghemoi-app:latest
```

## 5. Pull và chạy từ Docker Hub
```bash
docker pull ngobao14/congnghemoi-app:latest
docker-compose up -d
```

## 6. Deploy lên Server qua Termius

### Bước 1: Kết nối SSH qua Termius
1. Mở Termius
2. Tạo Host mới với IP server
3. Nhập username và password/SSH key
4. Kết nối

### Bước 2: Cài Docker trên server (nếu chưa có)
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install docker.io docker-compose -y
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
```

### Bước 3: Pull image từ Docker Hub
```bash
docker pull ngobao14/congnghemoi-app:latest
```

### Bước 5: Chạy container
```bash
docker run -d -p 8080:80 --name congnghemoi ngobao14/congnghemoi-app:latest
```
### Tắt sv: 
docker stop "id docker img"

### Cập nhật version mới
```bash
docker-compose down
docker pull ngobao14/congnghemoi-app:latest
docker-compose up -d
```

## 7. Cấu hình môi trường
Các biến môi trường trong `docker-compose.yml`:
- `USE_CLOUD_SQL`: true/false - sử dụng Cloud SQL hay MySQL local
- `CLOUD_SQL_HOST`: IP của Cloud SQL
- `CLOUD_SQL_USER`: Username
- `CLOUD_SQL_PASS`: Password
- `CLOUD_SQL_NAME`: Tên database

## 7. Troubleshooting

### Lỗi kết nối database
```bash
docker-compose down -v
docker-compose up -d
```

### Rebuild hoàn toàn
```bash
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

### Xem logs container cụ thể
```bash
docker logs congnghemoi_app
docker logs congnghemoi_db
```
