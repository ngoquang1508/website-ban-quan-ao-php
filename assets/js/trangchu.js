
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("voucherSlider");
    const track = document.getElementById("voucherTrack");
    const cards = track.querySelectorAll(".voucher-card");
    const cardCount = cards.length;
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const dotsContainer = document.getElementById("dotsContainer");

    // Tạo dots
    for (let i = 0; i < cardCount; i++) {
        const dot = document.createElement("div");
        dot.className = "voucher-slider__dot";
        dot.dataset.index = i;
        dotsContainer.appendChild(dot);
    }
    const dots = dotsContainer.querySelectorAll(".voucher-slider__dot");

    // Tính chiều rộng
    const getCardWidth = () => {
        if (!cards[0]) return 370;
        const style = window.getComputedStyle(cards[0]);
        const width = cards[0].offsetWidth;
        const gap = 40;
        return width + gap;
    };

    let cardWidth = getCardWidth();
    window.addEventListener("resize", () => cardWidth = getCardWidth());

    // Nhân đôi danh sách
    const cloneCount = cardCount;
    for (let i = 0; i < cloneCount; i++) {
        track.appendChild(cards[i].cloneNode(true));
    }

    let index = 0;
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    let autoplay;

    const updateTransform = () => {
        const offset = -index * cardWidth;
        track.style.transition = "transform 0.5s cubic-bezier(0.34, 0.66, 0.22, 1)";
        track.style.transform = `translateX(${offset}px)`;

        // Cập nhật active card
        document.querySelectorAll(".voucher-card").forEach((c, i) => {
            c.classList.remove("active");
            if (i % cardCount === index) c.classList.add("active");
        });

        // Cập nhật dots
        dots.forEach((d, i) => {
            d.classList.toggle("active", i === index);
        });
    };

    const nextSlide = () => {
        index = (index + 1) % cardCount;
        updateTransform();
    };

    const prevSlide = () => {
        index = (index - 1 + cardCount) % cardCount;
        updateTransform();
    };

    // Nút điều hướng
    nextBtn.addEventListener("click", () => { stopAutoplay(); nextSlide(); startAutoplay(); });
    prevBtn.addEventListener("click", () => { stopAutoplay(); prevSlide(); startAutoplay(); });

    // Dots click
    dots.forEach(dot => {
        dot.addEventListener("click", () => {
            stopAutoplay();
            index = parseInt(dot.dataset.index);
            updateTransform();
            startAutoplay();
        });
    });

    // Autoplay
    const startAutoplay = () => {
        autoplay = setInterval(nextSlide, 3000);
    };
    const stopAutoplay = () => clearInterval(autoplay);
    startAutoplay();

    // Drag & Touch
    const handleStart = (e) => {
        const isTouch = e.type.includes("touch");
        isDragging = true;
        startX = isTouch ? e.touches[0].pageX : e.pageX;
        currentX = startX;
        stopAutoplay();
        track.style.transition = "none";
    };

    const handleMove = (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const isTouch = e.type.includes("touch");
        const x = isTouch ? e.touches[0].pageX : e.pageX;
        const diff = x - currentX;
        currentX = x;
        const offset = -index * cardWidth + (x - startX);
        track.style.transform = `translateX(${offset}px)`;
    };

    const handleEnd = (e) => {
        if (!isDragging) return;
        isDragging = false;
        const isTouch = e.type.includes("touch");
        const endX = isTouch ? e.changedTouches[0].pageX : e.pageX;
        const diff = endX - startX;

        if (Math.abs(diff) > 60) {
            if (diff > 0) prevSlide();
            else nextSlide();
        } else {
            updateTransform();
        }
        startAutoplay();
    };

    // Events
    slider.addEventListener("mousedown", handleStart);
    slider.addEventListener("mousemove", handleMove);
    slider.addEventListener("mouseup", handleEnd);
    slider.addEventListener("mouseleave", handleEnd);

    slider.addEventListener("touchstart", handleStart, { passive: false });
    slider.addEventListener("touchmove", handleMove, { passive: false });
    slider.addEventListener("touchend", handleEnd);

    slider.addEventListener("mouseenter", stopAutoplay);
    slider.addEventListener("mouseleave", startAutoplay);

    // Khởi tạo
    updateTransform();
});
