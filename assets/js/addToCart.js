import { showToast } from "./toast.js";
import { updateCartCountUI } from "./global.js";

document.querySelectorAll(".product-card__add-to-cart").forEach((item) => {
  item.addEventListener("click", async () => {
    const productId = item.dataset.id;
    const qty = 1;

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

      if (data.status === "success") {
        showToast(data.message, data.status);
        item.classList.add("active");
        updateCartCountUI(data.cart_count);
      } else {
        showToast("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!", "error");
      }
    } catch (error) {
      console.log(error);
      showToast("Lỗi server", "error");
    }
  });
});
