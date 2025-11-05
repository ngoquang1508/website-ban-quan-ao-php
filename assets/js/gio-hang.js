import { showToast } from "/assets/js/toast.js";

// === Hàm gọi API ===
async function updateCart(action, productId, quantity = 1) {
  const res = await fetch("/api/cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ action, product_id: productId, quantity }),
  });
  return res.json();
}

// === Hàm tính tổng giỏ hàng ===
function updateCartTotal() {
  let sum = 0;
  document.querySelectorAll(".cart-item__price").forEach((p) => {
    const value = parseInt(p.textContent.replace(/\D/g, "")) || 0;
    sum += value;
  });
  document.querySelector(".cart__summary-total").innerHTML =
    sum.toLocaleString("vi-VN") + "<u>đ</u>";
}

// === Hàm xử lý xóa sản phẩm ===
async function handleRemoveItem(id) {
  try {
    const data = await updateCart("delete", id);
    if (data.status === "success") {
      const item = document.querySelector(`.cart-item[data-id="${id}"]`);
      if (item) {
        item.style.transition = "opacity 0.3s";
        item.style.opacity = "0";

        setTimeout(() => {
          item.remove();
          checkEmptyCart();
        }, 300);
      }
      updateCartTotal();
      showToast(data.message, "success");
    } else {
      showToast(data.message, "error");
    }
  } catch (error) {
    console.error(error);
    showToast("Không thể xóa sản phẩm!", "error");
  }
}

// Hàm kiểm tra giỏ hàng còn item không
function checkEmptyCart() {
  const cartList = document.querySelector(".cart__list");
  if (cartList.querySelectorAll(".cart-item").length === 0) {
    cartList.innerHTML =
      "<p style='font-size: 1.6rem; padding: 1rem; background: #fff3cd;'>Không có sản phẩm nào trong giỏ hàng của bạn.</p>";
  }
}

// === Hàm xử lý cập nhật số lượng ===
function setupCartItem(item) {
  const decrease = item.querySelector(".cart-qty__btn--decrease");
  const increase = item.querySelector(".cart-qty__btn--increase");
  const quantity = item.querySelector(".quantity");
  const priceElement = item.querySelector(".cart-item__price");
  const productId = item.dataset.id;

  const basePrice =
    parseInt(priceElement.textContent.replace(/\D/g, "")) /
    parseInt(quantity.value);
  const stock = parseInt(quantity.dataset.stock);
  let fetchTimer = null;

  function updateQuantity(change, manual = false) {
    let val = parseInt(quantity.value) || 1;
    if (!manual) val += change;

    if (val < 1) {
      val = 1;
      showToast("Số lượng không được nhỏ hơn 1!");
      return;
    } else if (val > stock) {
      val = stock;
      showToast("Đã vượt quá số lượng hiện có!");
    }

    // Cập nhật UI
    quantity.value = val;
    priceElement.innerHTML =
      (basePrice * val).toLocaleString("vi-VN") + "<u>đ</u>";
    updateCartTotal();

    // Gửi request (debounce)
    clearTimeout(fetchTimer);
    fetchTimer = setTimeout(async () => {
      const data = await updateCart("update", productId, val);
      if (data.status !== "success") {
        showToast(data.message || "Lỗi khi cập nhật giỏ hàng!", "error");
      }
    }, 600);
  }

  decrease.addEventListener("click", () => updateQuantity(-1));
  increase.addEventListener("click", () => updateQuantity(1));
  quantity.addEventListener("blur", () => updateQuantity(0, true));

  // Xóa sản phẩm
  const removeBtn = item.querySelector(".cart-item__remove");
  removeBtn.addEventListener("click", () => handleRemoveItem(productId));
}

// === Gắn handler cho từng sản phẩm ===
document.querySelectorAll(".cart-item").forEach(setupCartItem);
