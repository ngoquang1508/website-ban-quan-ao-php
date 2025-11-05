<?php
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
        /* ---------------------------- */
        /* CSS cô lập chỉ cho trang liên hệ */
        /* ---------------------------- */
        .contact-page {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 40px 0 60px;
        }

        .contact-page .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Breadcrumb */
        .contact-page .bread-crumb {
            display: block;
            margin: 20px 0;
            font-size: 16px;
            color: #6c757d;
        }
        .contact-page .bread-crumb a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .contact-page .bread-crumb a:hover {
            color: #0056b3;
        }

        /* Tiêu đề */
        .contact-page h1 {
            text-align: center;
            font-size: 32px;
            margin: 20px 0;
            font-weight: 700;
            color: #212529;
        }
        .contact-page p.description {
            text-align: center;
            color: #6c757d;
            font-size: 18px;
            margin-bottom: 40px;
        }

        /* Khối thông tin liên hệ */
        .contact-page .contact-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            gap: 20px;
            flex-wrap: wrap;
        }
        .contact-page .contact-block {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            flex: 1;
            min-width: 260px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .contact-page .contact-block:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .contact-page .contact-block i {
            font-size: 45px;
            color: #ff5722;
            margin-bottom: 15px;
        }
        .contact-page .contact-block p {
            margin: 5px 0;
            font-size: 16px;
        }
        .contact-page .contact-block p.title {
            font-weight: 500;
            font-size: 18px;
        }

        /* Bố cục map + form */
        .contact-page .row {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }
        .contact-page .col-left {
            flex: 1 1 60%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .contact-page .col-right {
            flex: 1 1 35%;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .contact-page iframe {
            width: 100%;
            height: 450px;
            border: 0;
            display: block;
        }

        /* Form liên hệ */
        .contact-page form {
            display: flex;
            flex-direction: column;
        }
        .contact-page input,
        .contact-page textarea {
            margin-bottom: 18px;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .contact-page input:focus,
        .contact-page textarea:focus {
            border-color: #ff5722;
            box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.25);
            outline: none;
        }
        .contact-page button {
            background: #ff5722;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .contact-page button:hover {
            background: #e64a19;
            transform: translateY(-2px);
        }

        /* Social icons */
        .contact-page .social-icons {
            margin-top: 25px;
            text-align: center;
        }
        .contact-page .social-icons a {
            margin-left: 15px;
            text-decoration: none;
        }
        .contact-page .social-icons i {
            font-size: 32px;
            color: #ff5722;
            transition: color 0.3s ease;
        }
        .contact-page .social-icons a:hover i {
            color: #e64a19;
        }

        /* Modal thông báo */
        .contact-page .success-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-in;
        }
        .contact-page .success-content {
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .contact-page .success-content h2 {
            color: #ff5722;
            font-size: 22px;
            margin-bottom: 15px;
        }
        .contact-page .success-content p {
            color: #555;
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .contact-page .success-content button {
            background: linear-gradient(90deg, #ff5722 0%, #e64a19 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .contact-page .success-content button:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #e64a19 0%, #ff5722 100%);
        }

        /* Animation */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-page .contact-info {
                flex-direction: column;
            }
            .contact-page .row {
                flex-direction: column;
            }
            .contact-page .col-left,
            .contact-page .col-right {
                width: 100%;
            }
            .contact-page .col-right {
                margin-top: 30px;
            }
            .contact-page .success-content {
                max-width: 90%;
                padding: 20px 25px;
            }
        }
    </style>
</head>

<body>
<div class="contact-page">
    <div class="container">

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3529.9585518338185!2d105.81382491057396!3d21.0361940805342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab128faefb3b%3A0x8c585f41f8238286!2zMjY2IMSQ4buZaSBD4bqlbiwgTGnhu4V1IEdpYWksIEJhIMSQw6xuaCwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e1!3m2!1svi!2s!4v1760931163768!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
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
            <h2>Quý khách đã gửi phản hồi thành công! Chúc quý khách một ngày tốt lành</h2>
            <p><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
            <button onclick="closeModal()">Đóng</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('', { method: 'POST', body: formData })
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
        if (event.target === modal) closeModal();
    });
</script>
</body>
</html>