document.addEventListener("DOMContentLoaded", () => {
    /* ==================== REUSABLE SLIDER CLASS ==================== */
    class Slider {
        constructor(containerId, options = {}) {
            this.slider = document.querySelector(containerId);
            if (!this.slider) return;

            this.track = this.slider.querySelector(options.track || ".lookbook__track, #voucherTrack");
            this.items = this.track.querySelectorAll(options.item || ".lookbook__item, .voucher-card");
            this.dotsContainer = this.slider.querySelector(options.dots || "#lookbookDots, #dotsContainer");
            this.prevBtn = this.slider.querySelector(options.prev || ".lookbook__nav--prev, .voucher-slider__nav--prev");
            this.nextBtn = this.slider.querySelector(options.next || ".lookbook__nav--next, .voucher-slider__nav--next");

            this.index = 0;
            this.total = this.items.length;
            this.autoPlay = null;
            this.isDragging = false;
            this.startX = 0;
            this.walk = 0;

            // Cấu hình riêng
            this.isVoucher = containerId.includes("voucher");
            this.gap = this.isVoucher ? 40 : 0; // voucher có gap 40px
            this.cardWidth = this.isVoucher ? this.items[0].offsetWidth + this.gap : window.innerWidth;

            this.init();
        }

        init() {
            this.createDots();
            if (this.isVoucher) this.cloneForInfinite(); // chỉ voucher mới cần infinite
            this.update();

            this.bindEvents();
            this.startAutoPlay();
            this.handleResize();
        }

        createDots() {
            if (!this.dotsContainer) return;
            this.dotsContainer.innerHTML = "";
            for (let i = 0; i < this.total; i++) {
                const dot = document.createElement("span");
                dot.className = this.isVoucher ? "voucher-slider__dot" : "lookbook__dots-span";
                if (i === 0) dot.classList.add("active");
                dot.dataset.index = i;
                this.dotsContainer.appendChild(dot);
            }
            this.dots = this.dotsContainer.querySelectorAll("span");
        }

        cloneForInfinite() {
            // Chỉ dùng cho voucher để tạo hiệu ứng lướt vô tận
            this.items.forEach(item => {
                this.track.appendChild(item.cloneNode(true));
            });
        }

        update() {
            const offset = this.isVoucher 
                ? -this.index * (this.items[0].offsetWidth + this.gap)
                : -this.index * 100 + "%";

            this.track.style.transition = "transform 0.5s cubic-bezier(0.34, 0.66, 0.22, 1)";
            this.track.style.transform = this.isVoucher 
                ? `translateX(${offset}px)` 
                : `translateX(${offset})`;

            // Active item
            this.items.forEach((item, i) => {
                const realIndex = this.isVoucher ? i % this.total : i;
                item.classList.toggle(this.isVoucher ? "active" : "lookbook__item--active", realIndex === this.index);
            });

            // Active dot
            this.dots?.forEach((dot, i) => {
                dot.classList.toggle("active", i === this.index);
            });
        }

        goTo(newIndex) {
            this.index = (newIndex + this.total) % this.total;
            this.update();
        }

        next() { this.goTo(this.index + 1); }
        prev() { this.goTo(this.index - 1); }

        startAutoPlay() {
            this.autoPlay = setInterval(() => this.next(), 5000);
        }

        stopAutoPlay() {
            clearInterval(this.autoPlay);
        }

        bindEvents() {
            this.nextBtn?.addEventListener("click", () => { this.stopAutoPlay(); this.next(); this.startAutoPlay(); });
            this.prevBtn?.addEventListener("click", () => { this.stopAutoPlay(); this.prev(); this.startAutoPlay(); });

            this.dots?.forEach(dot => {
                dot.addEventListener("click", () => {
                    this.stopAutoPlay();
                    this.goTo(+dot.dataset.index);
                    this.startAutoPlay();
                });
            });

            // Hover pause
            this.slider.addEventListener("mouseenter", () => this.stopAutoPlay());
            this.slider.addEventListener("mouseleave", () => this.startAutoPlay());

            // Touch & Drag
            const start = (e) => {
                this.isDragging = true;
                this.startX = e.type.includes("touch") ? e.touches[0].pageX : e.pageX;
                this.track.style.transition = "none";
                this.stopAutoPlay();
            };

            const move = (e) => {
                if (!this.isDragging) return;
                const x = e.type.includes("touch") ? e.touches[0].pageX : e.pageX;
                this.walk = x - this.startX;
                const offset = this.isVoucher
                    ? -this.index * (this.items[0].offsetWidth + this.gap) + this.walk
                    : -this.index * 100 + (this.walk / window.innerWidth) * 100 + "%";
                this.track.style.transform = this.isVoucher ? `translateX(${offset}px)` : `translateX(calc(${offset}))`;
            };

            const end = () => {
                if (!this.isDragging) return;
                this.isDragging = false;

                if (Math.abs(this.walk) > (this.isVoucher ? 80 : window.innerWidth * 0.2)) {
                    this.walk > 0 ? this.prev() : this.next();
                } else {
                    this.update();
                }
                this.startAutoPlay();
            };

            this.slider.addEventListener("mousedown", start);
            this.slider.addEventListener("mousemove", move);
            this.slider.addEventListener("mouseup", end);
            this.slider.addEventListener("mouseleave", end);

            this.slider.addEventListener("touchstart", start, { passive: false });
            this.slider.addEventListener("touchmove", move, { passive: false });
            this.slider.addEventListener("touchend", end);
        }

        handleResize() {
            window.addEventListener("resize", () => {
                clearTimeout(this.resizeTimer);
                this.resizeTimer = setTimeout(() => {
                    this.cardWidth = this.isVoucher ? this.items[0].offsetWidth + this.gap : window.innerWidth;
                    this.update();
                }, 200);
            });
        }
    }

    /* ==================== KHỞI TẠO 2 SLIDER ==================== */
    new Slider("#voucherSlider", {
        track: "#voucherTrack",
        item: ".voucher-card",
        dots: "#dotsContainer",
        prev: ".voucher-slider__nav--prev",
        next: ".voucher-slider__nav--next"
    });

    new Slider("#lookbook", {
        track: ".lookbook__track",
        item: ".lookbook__item",
        dots: "#lookbookDots",
        prev: ".lookbook__nav--prev",
        next: ".lookbook__nav--next"
    });
});