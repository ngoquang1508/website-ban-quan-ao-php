const sidebar = document.querySelector(".sidebar");
const toggleBtn = document.getElementById("sidebar-toggle");
const overlay = document.querySelector(".overlay");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("active");
  overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
});

function showLoading() {
  document.getElementById("loadingOverlay").style.display = "flex";
}
function hideLoading() {
  document.getElementById("loadingOverlay").style.display = "none";
}

function showSuccess(message = "Thao tác thành công!") {
  const toast = document.getElementById("successToast");
  const text = document.getElementById("successToastText");

  text.textContent = message;
  toast.style.opacity = 1;

  setTimeout(() => {
    toast.style.opacity = 0;
  }, 2000);
}

// logout
const logoutBtn = document.querySelector(".logout-btn");
console.log(logoutBtn)
logoutBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  try {
    await fetch("../api/auth.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "dang-xuat",
      }),
    });

    window.location.href = "../?page=dang-nhap";
  } catch (error) {
    console.error(error);
  }
});
