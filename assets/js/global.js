export const updateCartCountUI = (cartCount) => {
  const el = document.getElementById("count-item");
  if (el) el.textContent = cartCount;
};

// Regex cho số điện thoại Việt Nam (10 số, đầu 03,05,07,08,09)
export const phoneRegex = /^(03|05|07|08|09)\d{8}$/;
