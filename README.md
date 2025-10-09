# website-ban-quan-ao-php

## Bước 1: clone code về máy

``` bash
git clone https://github.com/ngoquang1508/website-ban-quan-ao-php.git
```

## Bước 2: 
1. Copy project vào htdocs
2. Khởi động Apache + mysql
3. Truy cập phpMyAdmin -> Tạo cơ sở dữ liệu mới tên `clothing_website`
4. Import file .sql

## Bước 3: DÀNH CHO LÀM VIỆC NHÓM
1. Mở terminal của thư mục gốc dự án
2. gõ lệnh:

```bash
git status
```
- Nếu branch ở nhánh *dev hoặc origin/dev thì thôi.
- Nếu branch ở nhánh *main. Gõ lệnh:

```bash
git checkout dev
```

## Bước 4: Quy trình làm việc
1. Khi bắt đầu làm việc:

```bash
git pull origin dev  # Cập nhật code mới nhất
git checkout -b feature/tên-tính-năng   # Tạo nhánh riêng để code
```

2. Sau khi code xong:
```bash
git add .
git commit -m "Mô tả ngắn gọn thay đổi"
git push origin feature/tên-tính-năng
