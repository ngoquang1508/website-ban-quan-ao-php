<!-- NHÚNG CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/he-thong-cua-hang.css">

<div class="stores-page">
    <div class="container">
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
                <div class="option-btn">
                    <button class="btn-find-near" id="btnFindNear">
                        <i class="fas fa-location-arrow"></i> Tìm cửa hàng gần tôi
                    </button>
                    <button class="btn-find-near" id="btnMyLocation" style="margin-top:10px;background:#1e88e5;">
                        <i class="fas fa-street-view"></i> Vị trí của tôi
                    </button>
    
                    <button class="btn-find-near" id="btnDirection" style="margin-top:10px;background:#43a047;">
                        <i class="fas fa-route"></i> Chỉ đường đến cơ sở
                    </button>
                </div>

            </div>

            <div class="col-right">
                <div class="map-wrapper">
                    <iframe id="map" src="" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?= BASE_URL ?>assets/js/storeMap.js" type="module"></script>