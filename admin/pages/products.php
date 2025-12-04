<?php
require_once "../config/db.php";

// Lấy tất cả sản phẩm
$sql_product = "SELECT * FROM products ORDER BY id DESC";
$products = $conn->query($sql_product);
?>

<div class="container-fluid p-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Quản lý sản phẩm</h3>
        <div class="d-flex justify-content-between align-items-center gap-2">
            <button class="btn btn-success" id="importExcelBtn" onclick="document.getElementById('excelInput').click()">Import Excel</button>
            <input type="file" id="excelInput" accept=".xlsx,.xls" hidden>

            <button class="btn btn-success" id="exportExcelBtn">Xuất excel</button>
            <button class="btn btn-primary" onclick="showAddProductModal()">Thêm sản phẩm</button>
        </div>
    </div>

    <div class="card shadow-sm p-3 mt-3">
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-hover align-middle" data-table="<?= $_GET['page'] ?>">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Loại</th>
                        <th>Giới tính</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($p = $products->fetch_assoc()): ?>
                        <tr id="productRow<?= $p['id'] ?>">
                            <td><?= $i++ ?></td>
                            <td class="pro-img"><img src="<?= BASE_URL . "../" . $p['url_image'] ?>" style="width:80px;height:80px;object-fit:cover;"></td>
                            <td class="productName search-field"><?= htmlspecialchars($p['name']) ?></td>
                            <td class="productPrice"><?= number_format($p['price']) ?></td>
                            <td class="productStock"><?= $p['stock'] ?></td>
                            <td class="productType search-field"><?= htmlspecialchars($p['type']) ?></td>
                            <td class="productSexual search-field"><?= htmlspecialchars($p['sexual']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-info"
                                    onclick='showProductDetail(<?= json_encode($p, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Xem chi tiết</button>
                                <button class="btn btn-sm btn-warning"
                                    onclick='showEditProductModal(<?= json_encode($p, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Sửa</button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="deleteProduct(<?= $p['id'] ?>)">Xóa</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODALS -->
<!-- Modal Add Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Giá</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tồn kho</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Loại</label>
                        <select name="type" class="form-select" required>
                            <option value="Áo">Áo</option>
                            <option value="Quần">Quần</option>
                            <option value="Phụ kiện">Phụ kiện</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Giới tính</label>
                        <select name="sexual" class="form-select" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Ảnh sản phẩm</label>

                        <div id="dropAreaAdd"
                            style="border:2px dashed #ccc;padding:20px;text-align:center;border-radius:10px;cursor:pointer;">
                            <p>Kéo & Thả ảnh vào đây hoặc bấm để chọn</p>
                            <img id="previewAdd" style="max-width:150px;display:none;margin-top:10px;">
                        </div>

                        <input type="file" id="addImage" name="image" class="form-control" accept="image/*" hidden required>
                    </div>

                    <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Product -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editProductId">
                    <div class="mb-3">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="name" id="editProductName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="description" id="editProductDesc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Giá</label>
                        <input type="number" name="price" id="editProductPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tồn kho</label>
                        <input type="number" name="stock" id="editProductStock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Loại</label>
                        <select name="type" id="editProductType" class="form-select" required>
                            <option value="Áo">Áo</option>
                            <option value="Quần">Quần</option>
                            <option value="Phụ kiện">Phụ kiện</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Giới tính</label>
                        <select name="sexual" id="editProductSexual" class="form-select" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Ảnh sản phẩm (bỏ trống nếu không đổi)</label>
                        <div id="dropAreaEdit"
                            style="border:2px dashed #ccc;padding:20px;text-align:center;border-radius:10px;cursor:pointer;">
                            <p>Kéo & Thả ảnh mới hoặc bấm để chọn</p>
                            <img id="previewEdit" style="max-width:150px;display:none;margin-top:10px;">
                        </div>

                        <input type="file" id="editProductImage" name="image" accept="image/*" hidden>

                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Product Detail -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex gap-3">
                <img id="productImg" src="" style="width:250px;height:250px;object-fit:cover;border-radius:4px;">
                <div>
                    <p><strong>Mô tả:</strong> <span id="productDesc"></span></p>
                    <p><strong>Giá:</strong> <span id="productPrice"></span>₫</p>
                    <p><strong>Loại:</strong> <span id="productType"></span></p>
                    <p><strong>Giới tính:</strong> <span id="productSexual"></span></p>
                    <p><strong>Tồn kho:</strong> <span id="productStock"></span></p>
                    <p><strong>Ngày tạo:</strong> <span id="productCreatedAt"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- THÊM, SỬA, XÓA 1 SẢN PHẨM -->
<script>
    // --------- Hiển thị modal ----------
    function showAddProductModal() {
        new bootstrap.Modal(document.getElementById('addProductModal')).show();
    }

    function showProductDetail(p) {
        document.getElementById('productTitle').textContent = p.name;
        document.getElementById('productImg').src = "<?= BASE_URL . '../' ?>" + p.url_image;
        document.getElementById('productDesc').textContent = p.description || 'Không có mô tả';
        document.getElementById('productPrice').textContent = Number(p.price).toLocaleString();
        document.getElementById('productType').textContent = p.type;
        document.getElementById('productSexual').textContent = p.sexual;
        document.getElementById('productStock').textContent = p.stock;
        document.getElementById('productCreatedAt').textContent = p.created_at;

        new bootstrap.Modal(document.getElementById('productDetailModal')).show();
    }

    function showEditProductModal(p) {
        document.getElementById('editProductId').value = p.id;
        document.getElementById('editProductName').value = p.name;
        document.getElementById('editProductDesc').value = p.description;
        document.getElementById('editProductPrice').value = p.price;
        document.getElementById('editProductStock').value = p.stock;
        document.getElementById('editProductType').value = p.type;
        document.getElementById('editProductSexual').value = p.sexual;
        document.getElementById('editProductImage').value = "";

        new bootstrap.Modal(document.getElementById('editProductModal')).show();
    }

    // Thêm sản phẩm
    document.getElementById('addProductForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        showLoading();

        try {
            const res = await fetch('api/products.php?action=add', {
                method: 'POST',
                body: new FormData(this)
            });

            const data = await res.json();

            if (data.status === 'success') {
                showSuccess(data.message);
                const tbody = document.querySelector('table tbody');
                const p = data.product;
                const i = tbody.rows.length + 1;

                const row = document.createElement('tr');
                row.id = 'productRow' + p.id;

                row.innerHTML = `
                <td>${i}</td>
                <td><img src="<?= BASE_URL . '../' ?>${p.url_image}" style="width:80px;height:80px;object-fit:cover;"></td>
                <td class="productName">${p.name}</td>
                <td class="productPrice">${Number(p.price).toLocaleString()}</td>
                <td class="productStock">${p.stock}</td>
                <td class="productType">${p.type}</td>
                <td class="productSexual">${p.sexual}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick='showProductDetail(${JSON.stringify(p)})'>Xem chi tiết</button>
                    <button class="btn btn-sm btn-warning" onclick='showEditProductModal(${JSON.stringify(p)})'>Sửa</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Xóa</button>
                </td>
            `;

                tbody.prepend(row);

                bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                this.reset();
                showSuccess("Thêm sản phẩm thành công!");

            } else {
                alert(data.message);
            }

        } catch (err) {
            console.error(err);
            alert("Có lỗi xảy ra khi thêm sản phẩm!");
        }
        hideLoading();
    });

    // Sửa sản phẩm
    document.getElementById('editProductForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = new FormData(this);

        showLoading();

        try {
            const res = await fetch('api/products.php?action=edit', {
                method: 'POST',
                body: form
            });

            const data = await res.json();

            if (data.status === 'success') {
                showSuccess(data.message);
                const row = document.getElementById('productRow' + form.get('id'));

                row.querySelector('.productName').textContent = form.get('name');
                row.querySelector('.productPrice').textContent = Number(form.get('price')).toLocaleString();
                row.querySelector('.productStock').textContent = form.get('stock');
                row.querySelector('.productType').textContent = form.get('type');
                row.querySelector('.productSexual').textContent = form.get('sexual');

                if (data.url_image) {
                    row.querySelector('td img').src = "<?= BASE_URL . '../' ?>" + data.url_image;
                }

                bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
                showSuccess("Cập nhật sản phẩm thành công!");

            } else {
                alert(data.message);
            }
            hideLoading();
        } catch (err) {
            console.error(err);
            alert("Có lỗi xảy ra khi sửa sản phẩm!");
        }
    });


    // --------- Xóa sản phẩm ----------
    async function deleteProduct(id) {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;
        
        showLoading();

        try {
            const res = await fetch(`api/products.php?action=delete&id=${id}`);
            const data = await res.json();

            if (data.status === 'success') {
                showSuccess(data.message);
                document.getElementById('productRow' + id).remove();
            } else {
                alert(data.message);
            }
        } catch (err) {
            console.error(err);
            alert("Có lỗi xảy ra, vui lòng thử lại!");
        }
        hideLoading();
    }
</script>

<!-- IMPORT EXCEL -->
<script>
    const fileInput = document.getElementById("excelInput");

    fileInput.addEventListener("change", async () => {
        if (!fileInput.files.length) return;

        const file = fileInput.files[0];

        if (!confirm(`Bạn có chắc muốn nhập file Excel "${file.name}" không?`)) {
            fileInput.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = async (e) => {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: "array"
            });

            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];

            let rows = XLSX.utils.sheet_to_json(sheet, {
                defval: ""
            });

            const mappedRows = rows.map((r) => ({
                name: r["Tên sản phẩm"] || r["name"] || "",
                description: r["Mô tả"] || r["description"] || "",
                price: r["Giá"] || r["price"] || 0,
                stock: r["Tồn kho"] || r["stock"] || 0,
                type: r["Loại"] || r["type"] || "",
                sexual: r["Giới tính"] || r["sexual"] || "",
                url_image: r["url_image"] || ""
            }));

            // Tạo FormData để gửi lên server
            const formData = new FormData();
            formData.append("action", "importExcel");
            formData.append("rows", JSON.stringify(mappedRows));

            showLoading();

            try {
                const res = await fetch("api/products.php", {
                    method: "POST",
                    body: formData
                });

                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error("JSON parse error:", e, "Response text:", text);
                    return;
                }

                // Cập nhật bảng sản phẩm
                if (data.status === "success" && data.products.length) {
                    showSuccess(data.message);
                    const tbody = document.querySelector("#productTable tbody");
                    data.products.forEach(p => {
                        const i = tbody.rows.length + 1;
                        const tr = document.createElement("tr");
                        tr.id = "productRow" + p.id;
                        tr.innerHTML = `
                            <td>${i}</td>
                            <td><img src="<?= BASE_URL . '../' ?>${p.url_image}" style="width:80px;height:80px;object-fit:cover;"></td>
                            <td class="productName">${p.name}</td>
                            <td class="productPrice">${Number(p.price).toLocaleString()}</td>
                            <td class="productStock">${p.stock}</td>
                            <td class="productType">${p.type}</td>
                            <td class="productSexual">${p.sexual}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick='showProductDetail(${JSON.stringify(p)})'>Xem chi tiết</button>
                                <button class="btn btn-sm btn-warning" onclick='showEditProductModal(${JSON.stringify(p)})'>Sửa</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Xóa</button>
                            </td>
                        `;
                        tbody.prepend(tr);
                        // Cập nhật lại STT tất cả các dòng
                        Array.from(tbody.rows).forEach((row, index) => {
                            row.cells[0].textContent = index + 1;
                        });
                    });
                }

                fileInput.value = ""; // reset input
                hideLoading();
            } catch (err) {
                console.error("Fetch error:", err);
            }
        };

        reader.readAsArrayBuffer(file);
    });
</script>

<!-- KÉO THẢ UPLOAD ẢNH -->
<script>
    // ========== FUNCTION CHUNG ========== //
    function enableDragDrop(dropAreaId, fileInputId, previewId) {
        const drop = document.getElementById(dropAreaId);
        const input = document.getElementById(fileInputId);
        const preview = document.getElementById(previewId);

        // Khi click vào vùng drop → mở chọn file
        drop.addEventListener("click", () => input.click());

        // Kéo file vào
        drop.addEventListener("dragover", (e) => {
            e.preventDefault();
            drop.style.borderColor = "#007bff";
        });

        drop.addEventListener("dragleave", () => {
            drop.style.borderColor = "#ccc";
        });

        drop.addEventListener("drop", (e) => {
            e.preventDefault();
            drop.style.borderColor = "#ccc";

            if (!e.dataTransfer.files.length) return;

            const file = e.dataTransfer.files[0];
            input.files = e.dataTransfer.files;

            // Show preview
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        });

        // Khi chọn file bằng tay
        input.addEventListener("change", () => {
            if (!input.files.length) return;
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = "block";
        });
    }

    // ========== ÁP DỤNG ========== //
    enableDragDrop("dropAreaAdd", "addImage", "previewAdd");
    enableDragDrop("dropAreaEdit", "editProductImage", "previewEdit");
</script>

<script src="<?= BASE_URL ?>assets/js/excel.js"></script>