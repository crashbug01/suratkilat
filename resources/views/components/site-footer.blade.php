<footer class="border-t border-base-300 bg-base-200">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col gap-8 md:flex-row md:justify-between">
            <div class="max-w-sm">
                <x-logo class="text-primary" />
                <p class="mt-3 text-sm text-base-content/80">
                    Pembuat surat resmi dan semi-resmi berbahasa Indonesia. Gratis, tanpa daftar, dan isian Anda tidak disimpan di server.
                </p>
            </div>
            <nav aria-label="Tautan footer">
                <ul class="grid grid-cols-2 gap-x-8 gap-y-1 text-sm">
                    {{-- Halaman ini dibuat di S5-04 (hari 5); sebelumnya tautan menghasilkan 404. --}}
                    <li><a class="link link-hover inline-flex min-h-11 items-center" href="/tentang">Tentang</a></li>
                    <li><a class="link link-hover inline-flex min-h-11 items-center" href="/kontak">Kontak</a></li>
                    <li><a class="link link-hover inline-flex min-h-11 items-center" href="/kebijakan-privasi">Kebijakan privasi</a></li>
                    <li><a class="link link-hover inline-flex min-h-11 items-center" href="/syarat-penggunaan">Syarat penggunaan</a></li>
                </ul>
            </nav>
        </div>
        <p class="mt-8 border-t border-base-300 pt-4 text-xs text-base-content/70">
            Surat di situs ini adalah contoh dan alat bantu, bukan nasihat hukum.
            &copy; {{ date('Y') }} SuratKilat.
        </p>
    </div>
</footer>
