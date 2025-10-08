<div class="main__header">
    <div class="main_header-btn">
        <i class="fa-solid fa-chevron-left"></i>
    </div>

    <div class="main__header-search">
        <form action="xuly/search.php" method="post">
            <!-- kiểm tra url hiện tại có page là gì -->
            <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>">
            <!-- Kiểm tra url hiện tại có action không -->
            <input type="hidden" name="action" value="<?php echo isset($_GET['action']) ? $_GET['action'] : '' ?>">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

            <div class="main__header__search-input">
                <input type="text" placeholder="Search..." name="value">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <button onclick="return checkSearchInput()" type="submit" name="search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>


    <div class="main__header-action">
        <div class="main__header-notify">
            <i class="fa-solid fa-bell"></i>
            <span>3+</span>
        </div>
    </div>
</div>

<script>
    const searchInput = document.querySelector('.main__header__search-input input');
    const clearIcon = document.querySelector('.main__header__search-input i.fa-circle-xmark');

    searchInput.addEventListener('input', () => {
        clearIcon.style.display = searchInput.value ? 'block' : 'none';
    });

    clearIcon.addEventListener('click', () => {
        searchInput.value = '';
        clearIcon.style.display = 'none';
        searchInput.focus();
    });

    function checkSearchInput() {
        if (searchInput.value.trim() === "") {
            return false;
        }
        return true;
    }
</script>