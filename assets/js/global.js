export const updateCartCountUI = (cartCount) => {
  const el = document.getElementById("count-item");
  if (el) el.textContent = cartCount;
};
