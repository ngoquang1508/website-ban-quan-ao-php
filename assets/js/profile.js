import { showToast } from "./toast.js";
import { phoneRegex } from "./global.js";

/* ==========================
   THÔNG TIN CÁ NHÂN
=========================== */
const submitInfoBtn = document.getElementById("submit-info-btn");

submitInfoBtn.addEventListener("click", async () => {
  const username = document.querySelector("input[name='username']");
  const phone = document.querySelector("input[name='phone']");
  const address = document.querySelector("input[name='address']");

  // Validation
  if (!username.value.trim()) return showToast("Tên người dùng không được để trống", "warning"), username.focus();
  if (!phone.value.trim()) return showToast("Số điện thoại không được để trống", "warning"), phone.focus();
  if (!address.value.trim()) return showToast("Địa chỉ không được để trống", "warning"), address.focus();
  if (phone.value.length > 10 || !phoneRegex.test(phone.value.trim())) return showToast("Số điện thoại không hợp lệ", "warning"), phone.focus();

  // Gửi request update info
  try {
    const res = await fetch("api/profile.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "update_info",
        username: username.value.trim(),
        phone: phone.value.trim(),
        address: address.value.trim(),
      }),
    });
    const data = await res.json();
    showToast(data.message, data.status);
  } catch (err) {
    console.error(err);
    showToast("Có lỗi xảy ra.", "error");
  }
});

/* ==========================
   AVATAR MENU & MODAL
=========================== */
const modalAvatarView = document.querySelector(".modal-view");
const avatarViewBtn = document.querySelector(".avt-btn-item");
const avatarViewCloseBtn = document.querySelector(".modal-view button");
avatarViewBtn.addEventListener("click", () => {
  modalAvatarView.classList.add("open");
})

avatarViewCloseBtn.addEventListener("click", () => {
  modalAvatarView.classList.remove("open");
})

const avatarImage = document.getElementById("avt-img");
const options = document.querySelector(".options");

// Toggle menu
avatarImage.addEventListener("click", (e) => {
  e.stopPropagation();
  options.classList.toggle("open");
});

options.addEventListener("click", (e) => e.stopPropagation());
document.body.addEventListener("click", () => options.classList.remove("open"));

// Modal chọn ảnh
const chooseBtnItem = document.querySelector(".choose-btn-item");
const modalChangeAvt = document.querySelector(".modal-change-avt");
const closeBtns = document.querySelectorAll(".close-modal-btn");
const saveChangeBtn = document.querySelector(".save-change");
const uploadBtn = document.querySelector(".upload-btn");
const uploadInput = document.querySelector(".upload-input");
const avatarPreview = document.getElementById("avatarPreview");
const cameraIconBtn = document.querySelector(".camera-icon");
const step1 = document.querySelector(".step-1");
const step2 = document.querySelector(".step-2");

cameraIconBtn.addEventListener("click", () => {
  modalChangeAvt.classList.add("open");
});

chooseBtnItem.addEventListener("click", () => modalChangeAvt.classList.add("open"));
closeBtns.forEach(btn => btn.addEventListener("click", () => {
  modalChangeAvt.classList.remove("open");
  step1.style.display = "flex";
  step2.style.display = "none";
}));

uploadBtn.addEventListener("click", () => uploadInput.click());

uploadInput.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (!file) return;

  step1.style.display = "none";
  step2.style.display = "flex";

  const reader = new FileReader();
  reader.onload = e => avatarPreview.src = e.target.result;
  reader.readAsDataURL(file);
});

saveChangeBtn.addEventListener("click", async () => {
  const file = uploadInput.files[0];
  if (!file) return showToast("Chưa chọn ảnh");

  const formData = new FormData();
  formData.append("action", "upload_avatar");
  formData.append("avatar", file);

  try {
    const res = await fetch("api/profile.php", { method: "POST", body: formData });
    let data;
    try { data = await res.json(); } 
    catch { showToast("Server trả về không phải JSON", "error"); return; }

    showToast(data.message, data.status);
    if (data.status === "success" && data.file) avatarPreview.src = data.file;
  } catch (err) {
    console.error(err);
    showToast("Có lỗi xảy ra", "error");
  }

  modalChangeAvt.classList.remove("open");
  step1.style.display = "flex";
  step2.style.display = "none";

  // Gán ảnh header và profile
  document.querySelectorAll(".avatar-view").forEach(avatar=>{
      avatar.src = URL.createObjectURL(file);
    });
});

/* ==========================
   THAY ĐỔI MẬT KHẨU
=========================== */
const changePasswordBtn = document.getElementById("change-pwd-btn");

changePasswordBtn.addEventListener("click", async () => {
  const oldPass = document.querySelector(".input-pass-old").value;
  const newPass = document.querySelector(".input-pass-new").value;
  const rePass = document.querySelector(".input-pass-re").value;

  if (!oldPass || !newPass || !rePass) return showToast("Nhập đủ các trường để đổi mật khẩu!", "warning");
  if (oldPass === newPass) return showToast("Mật khẩu mới không được giống mật khẩu cũ", "warning");
  if (newPass.length < 6) return showToast("Mật khẩu mới không nhỏ hơn 6 ký tự", "warning");
  if (newPass !== rePass) return showToast("Mật khẩu mới không khớp!", "warning");

  try {
    const res = await fetch("api/profile.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "change_pass", input_pass_old: oldPass, input_pass_new: newPass }),
    });
    const data = await res.json();
    showToast(data.message, data.status);
    if (data.status === "success") {
      document.querySelector(".input-pass-old").value = "";
      document.querySelector(".input-pass-new").value = "";
      document.querySelector(".input-pass-re").value = "";
    }
  } catch (err) {
    console.error(err);
    showToast("Có lỗi xảy ra.", "error");
  }
});

/* ==========================
   NAV & FOCUS INPUT
=========================== */
const navItems = document.querySelectorAll(".profile-nav .item");
const contentItems = document.querySelectorAll(".profile-content .item");
const inputs = document.querySelectorAll("input[type='text']");
const icons = document.querySelectorAll(".input-group i");

navItems[0].classList.add("active");
navItems.forEach((item, i) => item.addEventListener("click", () => {
  navItems.forEach(i => i.classList.remove("active"));
  contentItems.forEach(i => i.classList.remove("active"));
  item.classList.add("active");
  contentItems[i].classList.add("active");
}));

icons.forEach((icon, i) => icon.addEventListener("click", () => {
  const input = inputs[i];
  input.focus();
  const length = input.value.length;
  input.setSelectionRange(length, length);
}));
