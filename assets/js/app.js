import { showToast } from "./toast.js";

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

// LOADING
function showLoading() {
  document.getElementById("loadingOverlay").style.display = "flex";
}
function hideLoading() {
  document.getElementById("loadingOverlay").style.display = "none";
}

// AUTH
if (
  page === "dang-nhap" ||
  page === "dang-ky" ||
  page === "quen-mat-khau" ||
  page === "doi-mat-khau"
) {
  const submitBtn = document.getElementById("submitBtn");
  submitBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const inputs = document.querySelectorAll(".input-box input");
  const formData = {};

  inputs.forEach((input) => {
    formData[input.name] = input.value.trim();
  });

  // Validate
  if (page === "dang-nhap" && (!formData.email || !formData.password))
    return showToast("Vui lòng nhập đầy đủ thông tin");
  if (page === "dang-ky" && (!formData.hoten || !formData.email || !formData.password || !formData.confirm_password))
    return showToast("Vui lòng nhập đầy đủ thông tin");
  if (page === "dang-ky" && formData.password !== formData.confirm_password)
    return showToast("Mật khẩu nhập lại không khớp");
  if (page === "quen-mat-khau" && !formData.email)
    return showToast("Vui lòng nhập email để khôi phục");
  if (page === "doi-mat-khau" && (!formData.password || !formData.confirm_password))
    return showToast("Vui lòng nhập đầy đủ thông tin");
  if (page === "doi-mat-khau" && formData.password !== formData.confirm_password)
    return showToast("Mật khẩu xác nhận không khớp");

  // Hiển thị loading
  showLoading();

  try {
    const res = await fetch("api/auth.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: page, ...formData }),
    });

    const data = await res.json();

    // Ẩn loading, hiện toast
    hideLoading();
    showToast(data.message, data.status);

    if (data.status === "success") {
      // Chọn trang redirect theo page/role
      let nextPage = "";
      switch (page) {
        case "dang-nhap":
          nextPage = data.role === "user" ? "?page=trang-chu" : "admin/";
          break;
        case "dang-ky":
          nextPage = "?page=dang-nhap";
          break;
        case "quen-mat-khau":
          nextPage = "?page=doi-mat-khau";
          break;
        case "doi-mat-khau":
          nextPage = "?page=dang-nhap";
          break;
      }

      // Delay chuyển trang 1s để toast hiển thị trước
      setTimeout(() => {
        window.location.href = nextPage;
      }, 1000);
    }
  } catch (error) {
    hideLoading(); // luôn hide loading nếu lỗi
    console.error(error);
    showToast("Lỗi server", "error");
  }
});

}
