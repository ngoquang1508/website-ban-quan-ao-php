import { showToast } from "./toast.js";

const decrementBtn = document.querySelector(".decrement-btn");
const incrementBtn = document.querySelector(".increment-btn");
const quantity = document.querySelector(".quantity");
const addToCartBtn = document.querySelector(".add-to-card");
const buyNowBtn = document.querySelector(".buy-now");

buyNowBtn.addEventListener("click", (e) => {
  const qty = parseInt(quantity.dataset.stock);
  if (qty < 1) {
    e.preventDefault();
    showToast("Sản phẩm hiện hết hàng! Vui lòng chờ cập nhật thêm", "info");
    return;
  }
});

addToCartBtn.addEventListener("click", async (e) => {
  e.preventDefault();
  const productId = addToCartBtn.dataset.id;
  const qty = parseInt(quantity.dataset.stock);

  if (qty < 1) {
    showToast("Sản phẩm hiện hết hàng! Vui lòng chờ cập nhật thêm", "info");
    return;
  }

  try {
    const res = await fetch("api/cart.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "add",
        product_id: productId,
        quantity: qty,
      }),
    });

    const data = await res.json();
    console.log(data);

    if (data.status === "success") {
      showToast("Đã thêm sản phẩm vào giỏ hàng", data.status);
    } else {
      showToast(data.message || "Đã xảy ra lỗi", data.status);
    }
  } catch (error) {
    console.log(error);
    showToast("Không thể kết nối tới server", "error");
  }
});

// xử lý tăng giảm số lượng sản phẩm
decrementBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let current = parseInt(quantity.value) || 1;
  if (current > 1) {
    quantity.value = current - 1;
  }
});

incrementBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const max = parseInt(quantity.dataset.stock);
  let current = parseInt(quantity.value) || 1;
  if (current < max) {
    quantity.value = current + 1;
  }
});

quantity.addEventListener("blur", () => {
  const max = parseInt(quantity.dataset.stock);
  let val = parseInt(quantity.value);
  if (val < 1.01) {
    val = 1;
    showToast("Số lượng phải lớn hơn 1");
  }
  if (val > max) {
    val = max;
    showToast(`Số lượng phải nhỏ hơn ${max}`);
  }
  quantity.value = val;
});
