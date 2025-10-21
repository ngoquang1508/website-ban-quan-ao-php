<?php
function breadCrumb() {
    $root = '<a href="/index.php">Trang chủ</a>';
    return "<span class='bread-crumb'>$root > Hệ thống cửa hàng</span>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống cửa hàng ND Style</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* --------------------------
           ND THEME - HỆ THỐNG CỬA HÀNG
           -------------------------- */
        .stores-page {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 40px 0 60px;
        }
        .stores-page .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        /* Breadcrumb */
        .stores-page .bread-crumb {
            display: block;
            margin: 20px 0;
            font-size: 16px;
            color: #6c757d;
        }
        .stores-page .bread-crumb a {
            color: #007bff;
            text-decoration: none;
        }
        .stores-page .bread-crumb a:hover {
            color: #0056b3;
        }
        /* Title */
        .stores-page h1 {
            text-align: center;
            font-size: 30px;
            margin: 6px 0 10px;
            font-weight: 700;
            color: #1f2d36;
        }
        .stores-page p.description {
            text-align: center;
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 28px;
            max-width: 880px;
            margin-left: auto;
            margin-right: auto;
        }
        /* Thông tin nổi bật */
        .store-highlights {
            display: flex;
            justify-content: space-around;
            align-items: center;
            border: 1px solid #ff5a3c;
            border-radius: 10px;
            padding: 16px 10px;
            margin: 20px auto 40px;
            max-width: 1000px;
            background: #fff;
            flex-wrap: wrap;
            gap: 20px;
        }
        .highlight-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 280px;
        }
        .highlight-item .icon {
            background-color: #ff5a3c;
            color: #fff;
            font-size: 20px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(255, 90, 60, 0.3);
        }
        .highlight-item .text strong {
            color: #1f2d36;
            font-size: 15px;
        }
        .highlight-item .text span {
            color: #6c757d;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .store-highlights {
                flex-direction: column;
                text-align: center;
            }
            .highlight-item {
                justify-content: center;
            }
        }
        /* Layout */
        .stores-page .row {
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }
        /* Left column */
        .stores-page .col-left {
            flex: 1 1 360px;
            max-width: 420px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(23, 27, 31, 0.06);
            padding: 26px;
            margin-bottom: 20px;
        }
        .stores-page label.filter-label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2e3438;
            font-size: 15px;
        }
        .stores-page .select-wrapper {
            position: relative;
        }
        .stores-page select#coso {
            width: 100%;
            padding: 12px 44px 12px 14px;
            font-size: 15px;
            border: 1px solid #d8dde2;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            appearance: none;
        }
        .stores-page .select-wrapper::after {
            content: '\f107';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a96a0;
            font-size: 14px;
        }
        .stores-page .btn-find-near {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #ff5722;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
        }
        .stores-page .btn-find-near:hover {
            background: #e64a19;
        }
        /* Right column */
        .stores-page .col-right {
            flex: 1 1 560px;
            min-width: 300px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(23,27,31,0.06);
            background: #fff;
            overflow: hidden;
            position: relative;
        }
        .stores-page .map-wrapper {
            width: 100%;
            aspect-ratio: 16 / 9;
            min-height: 320px;
            background: #e9eef2;
            position: relative;
        }
        .stores-page .map-wrapper iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
<body>
    <div class="stores-page">
        <div class="container">
            <?= breadCrumb(); ?>
            <h1>Hệ thống cửa hàng ND Style</h1>
            <p class="description">Tìm cửa hàng ND Style gần bạn nhất — chúng tôi có mặt trên toàn quốc.</p>

            <div class="store-highlights">
                <div class="highlight-item">
                    <div class="icon"><i class="fas fa-store"></i></div>
                    <div class="text"><strong>Hệ thống 8 cửa hàng</strong><br><span>Trên toàn quốc</span></div>
                </div>
                <div class="highlight-item">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="text"><strong>Hơn 100 nhân viên</strong><br><span>Phục vụ tận tâm</span></div>
                </div>
                <div class="highlight-item">
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <div class="text"><strong>Mở cửa 8–22h</strong><br><span>Cả CN & Lễ Tết</span></div>
                </div>
            </div>

            <div class="row">
                <div class="col-left">
                    <label for="coso" class="filter-label">Chọn cơ sở:</label>
                    <div class="select-wrapper">
                        <select id="coso">
                            <option value="hn">Hà Nội - 266 Đội Cấn, Ba Đình</option>
                            <option value="hcm">TP. Hồ Chí Minh - 245 Nguyễn Thị Minh Khai, Q.1</option>
                            <option value="dn">Đà Nẵng - 97 Lê Lợi, Hải Châu</option>
                            <option value="ct">Cần Thơ - 68 Trần Hưng Đạo, Ninh Kiều</option>
                            <option value="hp">Hải Phòng - 12 Điện Biên Phủ, Ngô Quyền</option>
                        </select>
                    </div>
                    <button class="btn-find-near" id="btnFindNear">
                        <i class="fas fa-location-arrow"></i> Tìm cửa hàng gần tôi
                    </button>
                </div>

                <div class="col-right">
                    <div class="map-wrapper">
                        <iframe id="map" src="" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
const select = document.getElementById('coso');
const map = document.getElementById('map');
const btnFindNear = document.getElementById('btnFindNear');

const stores = {
    hn: {
        lat: 21.03619,
        lng: 105.81382,
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.863655820695!2d105.8116358154145!3d21.036194885994247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab7d7d8db4e7%3A0x78e7685e46d7e5b5!2zMjY2IMSQLiDEkOG7i2kgQ8OgbiwgQmEgxJDDrG5oLCBIw6AgTuG7mWksIFZpZXRuYW0!5e0!3m2!1svi!2s!4v1698222400000!5m2!1svi!2s"
    },
    hcm: {
        lat: 10.77482,
        lng: 106.69019,
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.669654496263!2d106.68800507460309!3d10.774820592317847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3f6d0a5a03%3A0x8b4a62f9a63b1d02!2zMjQ1IE5ndXnhu4VuIFRo4buLIE1pbmggS2hhaSwgUGjGsOG7nW5nIDEsIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1698222551111!5m2!1svi!2s"
    },
    dn: {
        lat: 16.07213,
        lng: 108.21895,
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.838073115744!2d108.21703071486747!3d16.07213088887365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219f0b85cf2e7%3A0xbdd3f78a8eecb3c1!2zOTcgTMOqIEzhu6NpLCBI4bqjaSBDaMOidSwgxJDDoCBO4bqvbmcsIFZpZXRuYW0!5e0!3m2!1svi!2s!4v1698222602222!5m2!1svi!2s"
    },
    ct: {
        lat: 10.03689,
        lng: 105.78964,
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.841518315751!2d105.78744631473995!3d10.036888992821099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08947ac0123c7%3A0xfed2d8d9a4a2f676!2zNjggVHLhuqduIEjGsG5nIMSQ4bqhaSwgTmluaCBLaeG7gXUsIEPhuqduIFRow7RuLCBWaWV0bmFt!5e0!3m2!1svi!2s!4v1698222703333!5m2!1svi!2s"
    },
    hp: {
        lat: 20.86481,
        lng: 106.68226,
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.3032599998847!2d106.68004031503592!3d20.864811986086678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3141a14839bfffb7%3A0xabcdd41e5fddc7e1!2zMTIgxJDhu4tuaCBCacOqbiBQaMO6LCBOZ8ahIFF1eeG7gW4sIEjhuqNpIFBow7JuZywgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1698222804444!5m2!1svi!2s"
    }
};

function updateMap(code) {
    if (!stores[code]) return;
    map.src = stores[code].map;
}

select.addEventListener('change', e => updateMap(e.target.value));
btnFindNear.addEventListener('click', () => {
    if (navigator.geolocation) {
        btnFindNear.disabled = true;
        navigator.geolocation.getCurrentPosition(
            pos => {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;
                let nearest = null;
                let minDist = Infinity;
                for (const [id, s] of Object.entries(stores)) {
                    const dist = Math.sqrt((s.lat - userLat) ** 2 + (s.lng - userLng) ** 2);
                    if (dist < minDist) {
                        minDist = dist;
                        nearest = id;
                    }
                }
                if (nearest) {
                    select.value = nearest;
                    updateMap(nearest);
                    alert("Cửa hàng gần bạn nhất: " + select.options[select.selectedIndex].text);
                }
                btnFindNear.disabled = false;
            },
            () => {
                alert("Không thể truy cập vị trí. Vui lòng bật GPS hoặc chọn thủ công.");
                btnFindNear.disabled = false;
            }
        );
    } else {
        alert("Trình duyệt không hỗ trợ định vị.");
    }
});

updateMap('hn');
</script>
</body>
</html>
