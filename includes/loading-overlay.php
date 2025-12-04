<!-- LOADING OVERLAY -->
<div id="loadingOverlay" style="
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
">
    <div class="spinner"></div>
</div>

<style>
    .spinner {
        width: 3rem;
        height: 3rem;
        border: 4px solid #ccc;
        /* màu nền */
        border-top: 4px solid #007bff;
        /* màu chạy */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Keyframe quay */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>