<?php
function SidebarFilter()
{
?>
    <div class="sidebar-filter__wrapper">
        <h2>Chọn mức giá</h2>
        <form action="?page=nu&q=" method="get">
            <ul class="sidebar-filter__list">
                <li class="sidebar-filter__item">
                    <label>
                        <input type="checkbox" name="" id="" onchange="this.form.submit()">
                        Giá dưới 200.000đ
                    </label>
                </li>

                <li class="sidebar-filter__item">
                    <label>
                        <input type="checkbox" name="" id="">
                        200.000đ - 500.000đ
                    </label>
                </li>

                <li class="sidebar-filter__item">
                    <label>
                        <input type="checkbox" name="" id="">
                        500.000đ - 700.000đ
                    </label>
                </li>

                <li class="sidebar-filter__item">
                    <label>
                        <input type="checkbox" name="" id="">
                        700.000đ - 1.000.000đ
                    </label>
                </li>

                <li class="sidebar-filter__item">
                    <label>
                        <input type="checkbox" name="" id="">
                        Giá trên 1.000.000đ
                    </label>
                </li>
            </ul>
        </form>
    </div>
<?php
}
?>