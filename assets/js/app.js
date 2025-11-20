/**
 * ĐỌC TITLE
 */
const params = new URLSearchParams(location.search);

const page = params.get("page") ?? "trang-chu";
const cat = params.get("cat") ?? "";

// Việt hóa PAGE
const pageMap = {
  "trang-chu": "Trang chủ",
  nam: "Nam",
  nu: "Nữ",
  "tin-tuc": "Tin Tức",
  "lien-he": "Liên hệ",
  "he-thong-cua-hang": "Hệ thống cửa hàng",
  "tim-kiem": "Tìm kiếm",
  "yeu-thich": "Yêu thích",
  "chi-tiet-san-pham": "Chi tiết sản phẩm",
  "gio-hang": "Giỏ hàng",
  "thong-tin-ca-nhan": "Thông tin cá nhân",
  "dang-nhap": "Đăng nhập",
  "dang-ky": "Đăng ký",
  "quen-mat-khau": "Quên mật khẩu",
  "doi-mat-khau": "Đổi mật khẩu",
};

// Việt hóa CATEGORY
const catMap = {
  "tat-ca": "Tất cả sản phẩm",
  "ao-nu": "Áo nữ",
  "quan-nu": "Quần nữ",
  "phu-kien-nu": "Phụ kiện nữ",
  "ao-nam": "Áo nam",
  "quan-nam": "Quần nam",
  "phu-kien-nam": "Phụ kiện nam",
};

const getName = (map, key) => map[key] || key.replace(/-/g, " ");
const title = cat
  ? `${getName(pageMap, page)} - ${getName(catMap, cat)} | Shop`
  : `${getName(pageMap, page)} | Shop`;

document.title = title;
