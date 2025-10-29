<?php
function SidebarFilter()
{
?>
    <div class="sidebar-filter__wrapper">
        <h2>Chọn mức giá</h2>
        <ul class="sidebar-filter__list">
            <li class="sidebar-filter__item">
                <label>
                    <input type="checkbox" value="under-200">
                    Giá dưới 200.000đ
                </label>
            </li>

            <li class="sidebar-filter__item">
                <label>
                    <input type="checkbox" value="200-500" >
                    200.000đ - 500.000đ
                </label>
            </li>

            <li class="sidebar-filter__item">
                <label>
                    <input type="checkbox" value="500-700" >
                    500.000đ - 700.000đ
                </label>
            </li>

            <li class="sidebar-filter__item">
                <label>
                    <input type="checkbox" value="700-1000" >
                    700.000đ - 1.000.000đ
                </label>
            </li>

            <li class="sidebar-filter__item">
                <label>
                    <input type="checkbox" value="over-1000" >
                    Giá trên 1.000.000đ
                </label>
            </li>
        </ul>
    </div>
<?php
}
?>