<header class="border-b border-base-300 bg-base-100">
    <div class="navbar mx-auto max-w-6xl px-4">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center text-lg text-primary" aria-label="SuratKilat, ke beranda">
                <x-logo />
            </a>
        </div>
        <nav class="flex-none" aria-label="Navigasi utama">
            <ul class="menu menu-horizontal gap-1 px-0">
                <li><a href="{{ route('home') }}#katalog" class="min-h-11">Katalog surat</a></li>
            </ul>
        </nav>
    </div>
</header>
