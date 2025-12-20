

<div class="container mx-auto md:px-4 bg-gradient-to-r from-blue-700 to-blue-400 " data-aos="fade-up">
    <div class="max-w-6xl mx-auto w-full flex flex-col md:flex-row items-center justify-between py-10 rounded-md">
        <div class="mb-10 md:mb-4 text-center md:text-left">
            <h1 class="font-bold text-2xl text-wrap md:text-3xl text-white px-10 md:px-0 mb-4">
                Ada yang bisa kami bantu?
            </h1>
            <div>
                <a href="https://wa.me/6282250590837?text={{ urlencode('Halo, saya butuh bantuan!') }}"
                    onclick="trackWhatsapp(event, this.href)"
                    class="rounded-lg text-gray-700 font-semibold py-2 px-4 border-2 outline-white hover:text-white bg-white hover:bg-blue-700 text-xs md:text-sm transition">
                    Pusat Bantuan
                </a>
            </div>
        </div>
        <div>
            <div class="flex items-center bg-white rounded-full justify-center">
                <img class="w-36 h-auto object-cover py-2 px-3 rounded-full" src="{{ asset('img/customer.png') }}"
                    alt="" />
            </div>
        </div>
    </div>
</div>

<script>
    function trackWhatsapp(e, url) {
        e.preventDefault();
        if (typeof fbq !== 'undefined') {
            fbq('trackCustom', 'WhatsAppClick');
        }
        setTimeout(() => {
            window.location.href = url;
        }, 300);
    }
</script>
