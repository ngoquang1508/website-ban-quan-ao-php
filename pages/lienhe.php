<?php
function breadCrumb() {
    $root = '<a href="/index.php">Trang chủ</a>';
    $page = isset($_GET['page']) ? htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8') : 'Liên hệ';
    return "<span class='bread-crumb'>$root > Liên hệ";
}

$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($name && $email && $phone && $message) {
        $successMessage = 'Cảm ơn quý khách đã tin tưởng và gửi thông tin. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất để hỗ trợ. Chúc quý khách một ngày tốt lành!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .bread-crumb {
            display: block;
            margin: 20px 0;
            font-size: 16px;
            color: #6c757d;
        }
        .bread-crumb a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .bread-crumb a:hover {
            color: #0056b3;
        }
        h1 {
            text-align: center;
            font-size: 32px;
            margin: 20px 0;
            font-weight: 700;
            color: #212529;
        }
        p.description {
            text-align: center;
            color: #6c757d;
            font-size: 18px;
            margin-bottom: 40px;
        }
        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            gap: 20px;
        }
        .contact-block {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            width: 32%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .contact-block:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .contact-block i {
            font-size: 45px;
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
            gap: 30px;
        }
        .col-left {
            width: 60%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
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
            height: 450px;
            border: 0;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus, textarea:focus {
            border-color: #ff5722;
            box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.25);
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

        /* Modal thông báo chuyên nghiệp */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease-in;
        }
        .success-content {
            background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
            padding: 30px 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid #e0e0e0;
        }
        .success-content h2 {
            color: #ff5722;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .success-content p {
            color: #555;
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .success-content button {
            background: linear-gradient(90deg, #ff5722 0%, #e64a19 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .success-content button:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #e64a19 0%, #ff5722 100%);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
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
            .success-content {
                max-width: 90%;
                padding: 20px 30px;
            }
            .success-content h2 {
                font-size: 20px;
            }
            .success-content p {
                font-size: 14px;
            }
        }

        /* Style cho footer nếu cần */
        .footer {
            background: #ff5722;
            color: white;
            padding: 40px 20px;
            border-top-left-radius: 50px;
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
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3529.9585518338185!2d105.81382491057396!3d21.0361940805342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab128faefb3b%3A0x8c585f41f8238286!2zMjY2IMSQ4buZaSBD4bqlbiwgTGnhu4V1IEdpYWksIEJhIMSQw6xuaCwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e1!3m2!1svi!2s!4v1760931163768!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-right">
                <form action="" method="post" id="contactForm">
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

    <div class="success-modal" id="successModal">
        <div class="success-content">
            <h2>Quý khách đã gửi phản hồi thành công! Chúc quý khách một ngày tốt lành.</h2>
            <p><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
            <button onclick="closeModal()">Đóng</button>
        </div>
    </div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById('successModal').style.display = 'flex';
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function closeModal() {
            const modal = document.getElementById('successModal');
            modal.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = 'fadeIn 0.3s ease-in';
            }, 300);
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('successModal');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>