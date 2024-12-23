<nav class="side-nav z-50 -mt-4 hidden w-[100px] overflow-x-hidden px-5 pb-16 pt-32 md:block xl:w-[260px]">
    <ul>
        <li>
            <a href="/home" class="side-menu">
                <div class="side-menu__icon">
                    <i data-tw-merge="" data-lucide="home" class="stroke-1.5 w-5 h-5"></i>
                </div>
                <div class="side-menu__title">
                    Dashboard
                </div>
            </a>
        </li>
        
        <li>
            <a href="/data-search" class="side-menu">
                <div class="side-menu__icon">
                    <i data-tw-merge="" data-lucide="file" class="stroke-1.5 w-5 h-5"></i>
                </div>
                <div class="side-menu__title">
                    Hasil Pencarian
                </div>
            </a>
        </li>
        
        <li>
            <a href="/video-metrics" class="side-menu">
                <div class="side-menu__icon">
                    <i data-tw-merge="" data-lucide="file" class="stroke-1.5 w-5 h-5"></i>
                </div>
                <div class="side-menu__title">
                    Video Metric
                </div>
            </a>
        </li>
    </ul>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll(".side-menu");

    menuItems.forEach(menu => {
        const menuPath = menu.getAttribute("href");
        if (menuPath === currentPath) {
            menu.classList.add("side-menu--active");
        } else {
            menu.classList.remove("side-menu--active");
        }
    });
});

</script>