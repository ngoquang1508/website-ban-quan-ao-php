<footer class="footer">
  <!-- Font Awesome -->
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css"
/>


  <style>
    .footer {
      background: linear-gradient(135deg, #ff5a3c, #ff7043);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      padding: 50px 0 25px;
      border-radius: 40px 40px 0 0;
      box-shadow: 0 -6px 20px rgba(0, 0, 0, 0.15);
      margin-top: 40px;
      overflow: hidden;
    }

    .footer-container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 40px;
      padding: 0 20px;
    }

    /* Logo */
    .footer-logo {
      flex: 1;
      min-width: 250px;
      text-align: center;
      border-bottom: 2px dotted rgba(255, 255, 255, 0.7);
      border-radius: 0 0 0 50px;
      padding-bottom: 25px;
    }

    .footer-logo h2 {
      font-family: 'Playfair Display', serif;
      font-size: 40px;
      letter-spacing: 1px;
      margin-bottom: 15px;
      color: #fff;
    }

    .footer-logo .connect-title {
      font-weight: 600;
      margin-bottom: 15px;
      letter-spacing: 1px;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 14px;
    }

    .social-icons a {
      background: white;
      color: #ff5a3c;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      transition: all 0.35s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    }

    .social-icons a:hover {
      background: #222;
      color: #fff;
      transform: translateY(-5px) rotate(-5deg);
    }

    /* Cột thông tin */
    .footer-column {
      flex: 1;
      min-width: 220px;
      color: #000;
    }

    .footer-column h3 {
      color: #000;
      font-size: 18px;
      margin-bottom: 12px;
      position: relative;
      font-weight: 700;
    }

    .footer-column h3::after {
      content: '';
      position: absolute;
      bottom: -6px;
      left: 0;
      width: 40px;
      height: 2px;
      background-color: #fff;
      border-radius: 10px;
    }

    .footer-column p,
    .footer-column ul li {
      font-size: 15px;
      line-height: 1.7;
    }

    .footer-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-column ul li {
      margin-bottom: 8px;
    }

    .footer-column ul li a {
      color: #000;
      text-decoration: none;
      position: relative;
      transition: all 0.3s ease;
    }

    .footer-column ul li a::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -2px;
      width: 0;
      height: 2px;
      background-color: #000;
      transition: width 0.3s ease;
    }

    .footer-column ul li a:hover {
      color: #fff;
    }

    .footer-column ul li a:hover::after {
      width: 100%;
    }

    /* Đáy footer */
    .footer-bottom {
      text-align: center;
      color: #000;
      margin-top: 40px;
      border-top: 1px solid rgba(255, 255, 255, 0.4);
      padding-top: 15px;
      font-size: 15px;
    }

    .footer-bottom strong {
      color: #fff;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .footer-container {
        flex-direction: column;
        text-align: center;
        gap: 30px;
      }

      .footer-column {
        min-width: 100%;
      }

      .footer-logo {
        border: none;
      }
    }
  </style>

  <div class="footer-container">
    <!-- Logo + MXH -->
    <div class="footer-column footer-logo">
      <h2>ND Style</h2>
      <p class="connect-title">KẾT NỐI</p>
      <div class="social-icons">
  <a href="https://www.tiktok.com" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
  <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
  <a href="https://www.facebook.com" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
  <a href="https://www.youtube.com" target="_blank"><i class="fa-brands fa-youtube"></i></a>
</div>

    </div>

    <!-- Cột 2 -->
    <div class="footer-column">
      <h3>CÔNG TY ND THEME</h3>
      <p>Số ĐKKD 0135792468 cấp ngày 30/05/2023 tại Sở KH&ĐT TP. Hà Nội</p>
      <p><strong>Địa chỉ:</strong> 266 Đội Cấn, Ba Đình, Hà Nội</p>
      <p><strong>Email:</strong> support@sapo.vn</p>
      <p><strong>Hotline:</strong> 1900 6750</p>
    </div>

    <!-- Cột 3 -->
    <div class="footer-column">
      <h3>VỀ CHÚNG TÔI</h3>
      <ul>
        <li><a href="gioithieu.php">Giới thiệu</a></li>
        <li><a href="lienhe.php">Liên hệ</a></li>
        <li><a href="tintuc.php">Tin tức</a></li>
        <li><a href="cuahang.php">Hệ thống cửa hàng</a></li>
        <li><a href="sanpham.php">Sản phẩm</a></li>
      </ul>
    </div>

    <!-- Cột 4 -->
    <div class="footer-column">
      <h3>DỊCH VỤ KHÁCH HÀNG</h3>
      <ul>
        <li><a href="kiemtradon.php">Kiểm tra đơn hàng</a></li>
        <li><a href="vanchuyen.php">Chính sách vận chuyển</a></li>
        <li><a href="doitra.php">Chính sách đổi trả</a></li>
        <li><a href="baomat.php">Bảo mật khách hàng</a></li>
        <li><a href="dangky.php">Đăng ký tài khoản</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© Bản quyền thuộc về <strong>ND Theme</strong> | Cung cấp bởi <strong>Sapo</strong></p>
  </div>
</footer>
