/*
 *  list.php
 */

// Xóa sản phẩm
document.querySelectorAll(".main-product__btn-delete").forEach((btn) => {
  btn.addEventListener("click", function (event) {
    if (!confirm("Bạn có chắc chắn xóa sản phẩm này không?")) {
      event.preventDefault();
    }
  });
});


/*
 * add.php
 */


// Kiểm tra các trường không trống
const nameInput = document.querySelector(".nameInput");
const desInput = document.querySelector(".desInput");
const priceInput = document.querySelector(".priceInput");
const stockInput = document.querySelector(".stockInput");
const photoInput = document.querySelector(".photoInput");
const submitBtn = document.querySelector(".submitBtn");

submitBtn.addEventListener("click", function (e) {
  if (
    nameInput.value.trim() === "" ||
    desInput.value.trim() === "" ||
    priceInput.value.trim() === "" ||
    stockInput.value.trim() === "" ||
    photoInput.value.trim() === ""
  ) {
    alert("Vui lòng điền đủ các trường");
    e.preventDefault();
  }
});


// Xử lý hiện file đã chọn
const input = document.getElementById("product-image");
const fileName = document.querySelector(".file-upload__name");

input.addEventListener("change", function () {
  if (this.files && this.files.length > 0) {
    fileName.textContent = this.files[0].name;
  } else {
    fileName.textContent = "Chưa có file";
  }
});