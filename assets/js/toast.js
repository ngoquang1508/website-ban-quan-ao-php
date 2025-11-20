export function showToast(message, status = "info") {
  let container = document.getElementById("toast-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "toast-container";
    document.body.appendChild(container);
  }

  const el = document.createElement("div");
  el.className = "toast";
  el.textContent = message;

  const colors = {
    success: "#4CAF50",
    info: "#2196F3",
    warning: "#FF9800",
    error: "#F44336"
  };

  el.style.background = colors[status] || colors.info;

  container.appendChild(el);

  // Hiển thị
  requestAnimationFrame(() => el.classList.add("show"));

  // Tự ẩn
  setTimeout(() => {
    el.classList.remove("show");
    el.classList.add("hide");
    setTimeout(() => el.remove(), 350);
  }, 2500);
}
