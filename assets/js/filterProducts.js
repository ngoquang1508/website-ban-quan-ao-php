// LỌC SẢN PHẨM Ở TRANG NAM NỮ

const container = document.querySelector(".products");
const products = Array.from(container.querySelectorAll(".product-card"));
document.querySelector("#sort").addEventListener("change", (e) => {
  const value = e.target.value;

  let sorted = [...products];
  if (value === "price-asc") {
    sorted.sort((a, b) => a.dataset.price - b.dataset.price);
  } else if (value === "price-desc") {
    sorted.sort((a, b) => b.dataset.price - a.dataset.price);
  } else if (value === "product-new") {
    // sản phẩm mới nhất lên đầu
    sorted.sort(
      (a, b) =>
        new Date(b.dataset.date).getTime() - new Date(a.dataset.date).getTime()
    );
  } else if (value === "product-old") {
    // sản phẩm cũ nhất lên đầu
    sorted.sort(
      (a, b) =>
        new Date(a.dataset.date).getTime() - new Date(b.dataset.date).getTime()
    );
  }

  // Xóa hết và thêm lại theo thứ tự mới
  container.innerHTML = "";
  sorted.forEach((p) => container.appendChild(p));
});
