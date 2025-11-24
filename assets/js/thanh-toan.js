import { showToast } from "./toast.js";

const qtyPrices = document.querySelectorAll(".qty-price span");
const tamTinh = document.querySelector(".value.tam-tinh");
const tongTien = document.querySelector(".value.total");
let total = 0;

// Tính tổng tạm tính
qtyPrices.forEach((qtyPrice) => {
  const value = parseInt(qtyPrice.textContent.replace(/[^\d]/g, ""), 10);
  total += value;
});

// Tổng tiền (thêm 40.000 phí vận chuyển)
const totalWithShipping = total + 40000;

// Định dạng theo tiền Việt
const formattedTamTinh = total.toLocaleString("vi-VN");
const formattedTongTien = totalWithShipping.toLocaleString("vi-VN");

// Gán vào HTML
tamTinh.innerHTML = formattedTamTinh + "<u>đ</u>";
tongTien.innerHTML = formattedTongTien + "<u>đ</u>";

// hàm xử lý validate khi nhập dữ liệu
const handleValidateForm = (data) => {
  // Lấy các input
  const nameInput = document.querySelector("input[name='name']");
  const emailInput = document.querySelector("input[name='email']");
  const phoneInput = document.querySelector("input[name='phone']");
  const addressInput = document.querySelector("input[name='address']");
  if (!data.name) {
    showToast("Họ và tên không được để trống", "warning");
    nameInput.focus();
    return false;
  }

  if (!data.email) {
    showToast("Email không được để trống", "warning");
    emailInput.focus();
    return false;
  }

  // Kiểm tra định dạng email cơ bản
  const emailRegex = /^\S+@\S+\.\S+$/;
  if (!emailRegex.test(data.email)) {
    showToast("Email không hợp lệ", "warning");
    emailInput.focus();
    return false;
  }

  if (!data.phone) {
    showToast("Số điện thoại không được để trống", "warning");
    phoneInput.focus();
    return false;
  }

  // Kiểm tra số điện thoại chỉ chứa số
  const phoneRegex = /^[0-9]{9,12}$/;
  if (!phoneRegex.test(data.phone)) {
    showToast("Số điện thoại không hợp lệ", "warning");
    phoneInput.focus();
    return false;
  }

  if (!data.address) {
    showToast("Địa chỉ không được để trống", "warning");
    addressInput.focus();
    return false;
  }

  if (!data.payment_method) {
    showToast("Chọn phương thức thanh toán", "warning");
    return false;
  }

  // Nếu tất cả hợp lệ
  return true;
};

// Hàm xử lý chọn phương thức thanh toán
const handleSelectedPaymentOption = () => {
  const paymentOptions = document.querySelectorAll(
    'input[name="payment_method"]'
  );
  let selectedOption = null;
  paymentOptions.forEach((opiton) => {
    if (opiton.checked) selectedOption = opiton.value;
  });

  return selectedOption;
};

// Lấy thông tin sản phẩm
const items = document.querySelectorAll(".list .item");
const itemData = Array.from(items).map((item) => {
  const productId = item.dataset.productId;
  const quantity = item.dataset.qty;
  const price = item.dataset.price;

  return {
    product_id: parseInt(productId, 10),
    quantity: quantity,
    price: price,
  };
});

const origin = window.origin;
const url = origin + window.location.pathname;

// Submit form
document.querySelector(".submit").addEventListener("click", async () => {
  // Lấy type từ cart hay detail
  const type = document.querySelector(".submit").dataset.type;

  const formData = {
    type: type,
    name: document.querySelector("input[name='name']").value.trim(),
    email: document.querySelector("input[name='email']").value.trim(),
    phone: document.querySelector("input[name='phone']").value.trim(),
    address: document.querySelector("input[name='address']").value.trim(),
    note: document.querySelector("textarea[name='note']").value.trim(),
    payment_method: handleSelectedPaymentOption(),
    items: itemData,
    total_price: totalWithShipping,
  };

  try {
    if (handleValidateForm(formData)) {
      const res = await fetch("api/checkout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      console.log(data);
      if (data?.status === "success") {
        showToast(data?.message, data?.status);
        setTimeout(() => {
          window.location.href = "?page=cam-on";
        }, 500);
      } else {
        showToast(data?.message, data?.status);
      }
    }
  } catch (error) {
    console.log(error)
    showToast("Có lỗi xảy ra!", "error");
  }
});
