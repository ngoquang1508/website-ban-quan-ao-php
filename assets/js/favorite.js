import { showToast } from "./toast.js";

const favoriteBtns = document.querySelectorAll(".product-card__favorite");

favoriteBtns.forEach((btn) =>
  btn.addEventListener("click", async () => {
    const productId = btn.dataset.id;
    const isActive = btn.classList.toggle("active");
    const action = isActive ? "add" : "remove";

    // Gửi Ajax đến PHP
    try {
      const res = await fetch("/api/favorite.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `product_id=${productId}&action=${action}`,
      });

      const data = await res.json();

      if (data.status === "success") {
        if (isActive) {
          showToast("Đã thêm sản phẩm vào danh sách yêu thích.", data.status);
        } else {
          showToast("Đã xóa sản phẩm khỏi danh sách yêu thích.");
        }
      } else {
        showToast(data.message || "Đã xảy ra lỗi", data.status);
        btn.classList.toggle("active", !isActive); // Hoàn tác nếu xảy ra lỗi
      }
    } catch (error) {
      console.log(error);
      showToast(error || "Không thể kết nối tới server", "error");
      btn.classList.toggle("active", !isActive); // Hoàn tác nếu xảy ra lỗi
    }
  })
);
