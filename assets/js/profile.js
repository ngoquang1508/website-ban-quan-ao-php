import { showToast } from "./toast.js";
import { phoneRegex } from "./global.js";

/**
 * THAY ĐỔI THÔNG TIN CÁ NHÂN
 */
const submitInfoBtn = document.getElementById("submit-info-btn");
submitInfoBtn.addEventListener("click", async () => {
  let username = document.querySelector("input[name='username']");
  let phone = document.querySelector("input[name='phone']");
  let address = document.querySelector("input[name='address']");

  if (username.value.trim() === "") {
    showToast("Tên người dùng không được để trống", "warning");
    username.focus();
    return;
  }
  if (phone.value.trim() === "") {
    showToast("Số điện thoại không được để trống", "warning");
    phone.focus();
    return;
  }
  if (address.value.trim() === "") {
    showToast("Địa chỉ không được để trống", "warning");
    address.focus();
    return;
  }

  if (phone.value.length > 10) {
    showToast("Số điện thoại không hợp lệ", "warning");
    phone.focus();
    return;
  }

  if (!phoneRegex.test(phone.value.trim())) {
    showToast("Số điện thoại không hợp lệ", "warning");
    phone.focus();
    return;
  }

  try {
    const res = await fetch("api/profile.php", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "update_info",
        username: username.value.trim(),
        phone: phone.value.trim(),
        address: address.value.trim(),
      }),
    });

    const data = await res.json();
    if (data?.status === "success") {
      showToast(data?.message, data?.status);
    } else {
      showToast(data?.message, data?.status);
    }
  } catch (error) {
    console.error(error);
    showToast("Có lỗi xảy ra.", "error");
  }
});

/**
 * THAY ĐỔI MẬT KHẨU
 */

const changePasswordBtn = document.getElementById("change-pwd-btn");
changePasswordBtn.addEventListener("click", async () => {
  // Lấy giá trị từ ô input
  let inputPassOld = document.querySelector(".input-pass-old").value;
  let inputPassNew = document.querySelector(".input-pass-new").value;
  let inputPassReEnter = document.querySelector(".input-pass-re").value;

  // Kiểm tra null
  if (inputPassOld === "" || inputPassNew === "" || inputPassReEnter === "") {
    showToast("Nhập đủ các trường để đổi mật khẩu!", "warning");
    return;
  }

  //   Kiểm tra pw cũ = pw mới
  if (inputPassOld === inputPassNew) {
    showToast("Mật khẩu mới không được giống mật khẩu cũ", "warning");
    return;
  }

  // Kiểm tra độ dài pass mới
  if (inputPassNew.length < 6) {
    showToast("Mật khẩu mới không nhỏ hơn 6 ký tự", "warning");
    return;
  }

  // Kiểm tra pw mới có giống với pw-re
  if (inputPassNew !== inputPassReEnter) {
    showToast("Mật khẩu mới không khớp!", "warning");
    return;
  }

  try {
    const res = await fetch("api/profile.php", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "change_pass",
        input_pass_old: inputPassOld,
        input_pass_new: inputPassNew,
      }),
    });

    const data = await res.json();

    if (data?.status === "success") {
      showToast(data?.message, data?.status);
      // reset input
      document.querySelector(".input-pass-old").value = "";
      document.querySelector(".input-pass-new").value = "";
      document.querySelector(".input-pass-re").value = "";
    } else {
      showToast(data?.message, data?.status);
    }
  } catch (error) {
    console.error(error);
    showToast("Có lỗi xảy ra.", "error");
  }
});

/**
 *  CHUYỂN THANH NAV VÀ FOCUS INPUT
 */

const navItems = document.querySelectorAll(".profile-nav .item");
const contentItems = document.querySelectorAll(".profile-content .item");

navItems[0].classList.add("active");
navItems.forEach((item, i) => {
  item.addEventListener("click", () => {
    navItems.forEach((i) => i.classList.remove("active"));
    contentItems.forEach((i) => i.classList.remove("active"));

    item.classList.add("active");
    contentItems[i].classList.add("active");
  });
});

const inputs = document.querySelectorAll("input[type='text']");
document.querySelectorAll(".input-group i").forEach((icon, i) => {
  icon.addEventListener("click", () => {
    const input = inputs[i];
    input.focus();
    // Đặt con trỏ ở cuối
    const length = input.value.length;
    input.setSelectionRange(length, length);
  });
});
