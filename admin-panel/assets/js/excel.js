document.getElementById("exportExcelBtn").addEventListener("click", () => {
  const table = document.querySelector("table");
  const clone = table.cloneNode(true);

  const page = table.dataset.table;
  let removeIndexes = [];

  // Xác định cột cần xóa theo page
  if (page === "products") {
    removeIndexes = [1, 7]; // Ảnh + Chức năng
  } else if (page === "users") {
    const colCount = table.querySelector("thead tr").children.length;
    removeIndexes = [colCount - 1]; // cột cuối
  } else if (page === "orders") {
    const colCount = table.querySelector("thead tr").children.length;
    removeIndexes = [colCount - 1]; // cột cuối
  }

  // Xóa cột
  clone.querySelectorAll("tr").forEach((tr) => {
    removeIndexes
      .slice()
      .sort((a, b) => b - a)
      .forEach((i) => {
        if (tr.children[i]) tr.removeChild(tr.children[i]);
      });
  });

  // Xuất Excel
  const wb = XLSX.utils.table_to_book(clone, { sheet: "Sheet1" });
  XLSX.writeFile(wb, page + ".xlsx");
});
