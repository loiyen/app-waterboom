import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";

import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

import lottie from "lottie-web";

//swet alert
import Swal from 'sweetalert2'
window.Swal = Swal


//tanggal-kunjungan-ticket
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", () => {
    flatpickr("#visit-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
    });
});

// ======== AOS ANIMATION ========
AOS.init({
    duration: 800,
    once: true,
});

// ======== LOTTIE LOADER ========
document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("loading");
    if (loader) {
        lottie.loadAnimation({
            container: document.getElementById("loadingAnimation"),
            renderer: "svg",
            loop: true,
            autoplay: true,
            path: "/animations/insider-loading.json",
        });

        loader.classList.add("opacity-0", "transition-opacity", "duration-700");
        setTimeout(() => {
            loader.style.display = "none";
        }, 700);
    }

    // ======== SWIPER SLIDER ======== ✅ masukkan ke dalam DOMContentLoaded
    const swiper = new Swiper(".default-carousel", {
        modules: [Navigation, Pagination, Autoplay], // ✅ wajib di Swiper v12
        loop: true,
        navigation: { nextEl: ".custom-next", prevEl: ".custom-prev" },
        pagination: { el: ".swiper-pagination", clickable: true },
        autoplay: { delay: 15000, disableOnInteraction: false },
    });

    const swiper1 = new Swiper(".multiple-slide-carousel", {
        modules: [Navigation, Pagination, Autoplay], // ✅ wajib juga
        loop: true,
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: ".multiple-slide-carousel .swiper-button-next",
            prevEl: ".multiple-slide-carousel .swiper-button-prev",
        },
        breakpoints: {
            1920: { slidesPerView: 3, spaceBetween: 30 },
            1028: { slidesPerView: 2, spaceBetween: 30 },
            990: { slidesPerView: 1, spaceBetween: 0 },
        },
    });
});

// ======== NAVBAR & DROPDOWN ========
const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");

if (hamburger && mobileMenu) {
    hamburger.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
        hamburger.classList.toggle("text-blue-800");
    });
}

document.querySelectorAll(".dropdown-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        const id = btn.dataset.dropdown;
        document.getElementById(id).classList.toggle("hidden");
    });
});

window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    if (navbar) {
        if (window.scrollY > 50) navbar.classList.add("shadow-lg");
        else navbar.classList.remove("shadow-lg");
    }
});

// === Tombol Tambah Tiket ===
window.tambahTiket = function (btn) {
    const input = btn.parentElement.querySelector(".jumlah-tiket");
    if (!input) return;

    let jumlah = parseInt(input.value) || 0;
    if (jumlah < 10) {
        // batas maksimal 10 tiket
        input.value = jumlah + 1;
    }
};

// === Tombol Kurang Tiket ===
window.kurangTiket = function (btn) {
    const input = btn.parentElement.querySelector(".jumlah-tiket");
    if (!input) return;

    let jumlah = parseInt(input.value) || 0;
    if (jumlah > 0) {
        // jangan kurang dari 0
        input.value = jumlah - 1;
    }
};



