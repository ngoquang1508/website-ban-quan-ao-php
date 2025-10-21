<?php

function breadCrumb() {
    $root = '<a href="/index.php">Trang chủ</a>';
    $page = isset($_GET['page']) ? htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8') : 'Liên hệ';
    return "<span class='bread-crumb'>$root > Liên hệ</span>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Thêm responsive -->
    <title>Liên hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Google Fonts cho typography đẹp hơn -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa; /* Nền nhẹ hơn, không trắng chói */
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px; /* Tăng padding cho thoáng hơn */
        }
        .bread-crumb {
            display: block;
            margin: 20px 0;
            font-size: 16px; /* Tăng size chữ */
            color: #6c757d;
        }
        .bread-crumb a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease; /* Hover effect */
        }
        .bread-crumb a:hover {
            color: #0056b3;
        }
        h1 {
            text-align: center;
            font-size: 32px; /* Tăng size tiêu đề */
            margin: 20px 0;
            font-weight: 700;
            color: #212529;
        }
        p.description {
            text-align: center;
            color: #6c757d;
            font-size: 18px; /* Tăng size */
            margin-bottom: 40px;
        }
        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            gap: 20px; /* Khoảng cách giữa blocks */
        }
        .contact-block {
            text-align: center;
            background: #ffffff; /* Nền trắng sạch */
            padding: 30px; /* Tăng padding */
            border-radius: 12px;
            width: 32%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Thêm shadow cho chiều sâu */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animation hover */
        }
        .contact-block:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .contact-block i {
            font-size: 45px; /* Tăng size icon */
            color: #ff5722;
            margin-bottom: 15px;
        }
        .contact-block p {
            margin: 5px 0;
            font-size: 16px;
        }
        .contact-block p.title {
            font-weight: 500;
            font-size: 18px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            gap: 30px; /* Khoảng cách giữa map và form */
        }
        .col-left {
            width: 60%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Shadow cho map */
            border-radius: 12px;
            overflow: hidden; /* Để border-radius áp dụng cho iframe */
        }
        .col-right {
            width: 35%;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        iframe {
            width: 100%;
            height: 450px; /* Tăng height map */
            border: 0;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 20px; /* Tăng khoảng cách */
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus, textarea:focus {
            border-color: #ff5722;
            box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.25); /* Focus effect đẹp */
            outline: none;
        }
        button {
            background: #ff5722;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background: #e64a19;
            transform: translateY(-2px);
        }
        .social-icons {
            margin-top: 25px;
            text-align: right;
        }
        .social-icons a {
            margin-left: 15px;
            transition: color 0.3s ease;
        }
        .social-icons i {
            font-size: 32px;
            color: #ff5722;
        }
        .social-icons a:hover i {
            color: #e64a19;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
            }
            .contact-block {
                width: 100%;
                margin-bottom: 20px;
            }
            .row {
                flex-direction: column;
            }
            .col-left, .col-right {
                width: 100%;
            }
            .col-right {
                margin-top: 30px;
            }
        }

        /* Style cho footer nếu cần (giả sử footer.php có class footer) */
        .footer {
            background: #ff5722;
            color: white;
            padding: 40px 20px;
            border-top-left-radius: 50px; /* Rounded top như ảnh */
            border-top-right-radius: 50px;
            margin-top: 50px;
            text-align: center;
        }
        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>


    <div class="container">
        <?php echo breadCrumb(); ?>

        <h1>Thông tin liên hệ</h1>
        <p class="description">Chúng tôi luôn sẵn sàng và có cơ hội đồng hành với hơn 10.000 khách hàng trên khắp thế giới.</p>

        <div class="contact-info">
            <div class="contact-block">
                <i class="fas fa-map-marker-alt"></i>
                <p class="title">Địa chỉ</p>
                <p>266 Đội Cấn, Ba Đình, Hà Nội</p>
            </div>
            <div class="contact-block">
                <i class="fas fa-envelope"></i>
                <p class="title">Email</p>
                <p>support@sapo.vn</p>
            </div>
            <div class="contact-block">
                <i class="fas fa-phone-alt"></i>
                <p class="title">Hotline</p>
                <p>1900 6750</p>
            </div>
        </div>

        <div class="row">
            <div class="col-left">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3529.9585518338185!2d105.81382491057396!3d21.0361940805342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab128faefb3b%3A0x8c585f41f8238286!2zMjY2IMSQ4buZaSBD4bqlbiwgTGnhu4V1IEdpYWksIEJhIMSQw6xuaCwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e1!3m2!1svi!2s!4v1760931163768!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
            <div class="col-right">
                <form action="submit_contact.php" method="post">
                    <input type="text" name="name" placeholder="Họ và tên" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="tel" name="phone" placeholder="Điện thoại" required>
                    <textarea name="message" placeholder="Nội dung" rows="5" required></textarea>
                    <button type="submit">Gửi thông tin</button>
                </form>
                <div class="social-icons">
                    <a href="https://www.tiktok.com/" target="_blank"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.messenger.com/" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>