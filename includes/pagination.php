<?php
function Pagination($currentPage, $totalPages, $page, $cat = "")
{
    if ($totalPages < 1) return;

    $category = "";
    if (isset($cat)) {
        $category = "&cat=" . $cat;
    }
    $baseUrl = '?page=' . $page . $category;

    $prevPage = max(1, $currentPage - 1);
    $nextPage = min($totalPages, $currentPage + 1);

    echo '<div class="pagination">';
    echo '<a href="' . $baseUrl . '&p=' . $prevPage . '" class="page-link ' . ($currentPage == 1 ? 'disabled' : '') . '">&laquo;</a>';

    if ($totalPages <= 7) {
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a href="' . $baseUrl . '&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
        }
    } else {
        if ($currentPage <= 4) {
            for ($i = 1; $i <= 5; $i++) {
                echo '<a href="' . $baseUrl . '&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
            }
            echo '<span class="page-dots">...</span>';
            echo '<a href="' . $baseUrl . '&p=' . $totalPages . '" class="page-link">' . $totalPages . '</a>';
        } elseif ($currentPage > 4 && $currentPage < $totalPages - 3) {
            echo '<a href="' . $baseUrl . '&p=1" class="page-link">1</a>';
            echo '<span class="page-dots">...</span>';
            for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                echo '<a href="' . $baseUrl . '&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
            }
            echo '<span class="page-dots">...</span>';
            echo '<a href="' . $baseUrl . '&p=' . $totalPages . '" class="page-link">' . $totalPages . '</a>';
        } else {
            echo '<a href="' . $baseUrl . '&p=1" class="page-link">1</a>';
            echo '<span class="page-dots">...</span>';
            for ($i = $totalPages - 4; $i <= $totalPages; $i++) {
                echo '<a href="' . $baseUrl . '&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
            }
        }
    }

    echo '<a href="' . $baseUrl . '&p=' . $nextPage . '" class="page-link ' . ($currentPage == $totalPages ? 'disabled' : '') . '">&raquo;</a>';
    echo '</div>';
}
