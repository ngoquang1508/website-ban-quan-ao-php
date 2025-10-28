const container = document.querySelector(".products");
const products = Array.from(container.querySelectorAll(".product-card"));
const sortSelect = document.querySelector("#sort");
const checkboxes = document.querySelectorAll(
  ".sidebar-filter__item input[type='checkbox']"
);

// Hàm hiển thị lại danh sách
function render(list) {
  const div = document.createElement("div");
  div.className = "empty-product";
  div.textContent = "Không có sản phẩm nào trong danh mục này.";

  container.innerHTML = "";

  if (Array.isArray(list) && list.length === 0) {
    container.appendChild(div);
  } else {
    list.forEach((p) => container.appendChild(p));
  }
}

// Hàm lọc + sắp xếp sản phẩm
function updateProducts() {
  let result = [...products];

  // --- Lọc theo checkbox ---
  const selected = Array.from(checkboxes)
    .filter((cb) => cb.checked)
    .map((cb) => cb.value);

  if (selected.length > 0) {
    result = result.filter((p) => {
      const price = parseFloat(p.dataset.price);
      return selected.some((range) => {
        if (range === "under-200") return price < 200000;
        if (range === "200-500") return price >= 200000 && price <= 500000;
        if (range === "500-700") return price >= 500000 && price <= 700000;
        if (range === "700-1000") return price >= 700000 && price <= 1000000;
        if (range === "over-1000") return price > 1000000;
      });
    });
  }

  // --- Sắp xếp theo select ---
  const sortValue = sortSelect.value;
  result.sort((a, b) => {
    const priceA = parseFloat(a.dataset.price);
    const priceB = parseFloat(b.dataset.price);
    const dateA = new Date(a.dataset.date).getTime();
    const dateB = new Date(b.dataset.date).getTime();

    switch (sortValue) {
      case "price-asc":
        return priceA - priceB;
      case "price-desc":
        return priceB - priceA;
      case "product-new":
        return dateB - dateA;
      case "product-old":
        return dateA - dateB;
      default:
        return 0;
    }
  });

  render(result);
}

// Gắn sự kiện
sortSelect.addEventListener("change", updateProducts);
checkboxes.forEach((cb) => cb.addEventListener("change", updateProducts));
