<x-layouts.app
    title="SuratKilat: Buat Surat Resmi Online, Gratis dan Siap Cetak"
    description="Isi formulir singkat, lihat suratnya terbentuk saat Anda mengetik, lalu unduh sebagai PDF A4. Gratis, tanpa daftar, dan data tidak disimpan di server."
>
    <section class="bg-base-200">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-12 lg:grid-cols-2 lg:py-20">
            <div>
                <h1 class="text-4xl font-bold leading-tight tracking-tight text-primary sm:text-5xl">
                    Surat rapi, selesai dalam hitungan menit.
                </h1>
                <p class="mt-5 max-w-prose text-lg text-base-content/80">
                    Isi formulir singkat, suratnya terbentuk saat Anda mengetik, lalu unduh sebagai PDF A4.
                    Tanpa daftar, dan isian Anda tidak disimpan di server.
                </p>
                <div class="mt-8">
                    <a href="#katalog" class="btn btn-primary min-h-11 px-6">Pilih jenis surat</a>
                </div>
            </div>

            {{-- Ilustrasi: contoh surat dalam format baku Indonesia --}}
            <div class="paper mx-auto w-full max-w-sm p-6 text-[11px] leading-relaxed sm:text-xs" aria-hidden="true">
                <p class="text-right">Bandung, 18 November 2026</p>
                <p class="mt-4">Yth. Bapak/Ibu Wali Kelas VII-B<br>SMP Negeri 1 Bandung<br>di tempat</p>
                <p class="mt-4">Dengan hormat,</p>
                <p class="mt-2">
                    Saya yang bertanda tangan di bawah ini, orang tua dari Rina Maharani, memberitahukan
                    bahwa putri kami tidak dapat mengikuti pelajaran pada 18 November 2026 karena sakit.
                </p>
                <p class="mt-2">Demikian surat ini kami sampaikan. Atas perhatian Bapak/Ibu, kami ucapkan terima kasih.</p>
                <div class="mt-6 w-32">
                    <p>Hormat saya,</p>
                    <div class="h-10"></div>
                    <p class="font-semibold underline">Dewi Maharani</p>
                </div>
            </div>
        </div>
    </section>

    <section id="katalog" class="mx-auto max-w-6xl scroll-mt-4 px-4 py-12">
        <h2 class="text-2xl font-bold text-primary">Katalog surat</h2>
        <p class="mt-2 max-w-prose text-base-content/80">
            Pilih kategori untuk melihat surat yang tersedia.
        </p>

        @if ($categories->isEmpty())
            <p class="mt-8 rounded-box border border-base-300 p-6">
                Katalog masih kosong. Jalankan <code>php artisan db:seed</code> untuk mengisi kategori.
            </p>
        @else
            <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <li class="rounded-box border border-base-300 p-5">
                        <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
                        @if ($category->description)
                            <p class="mt-2 text-sm text-base-content/80">{{ $category->description }}</p>
                        @endif
                        <p class="mt-4 text-sm font-medium text-secondary">
                            @if ($category->published_letter_types_count > 0)
                                {{ $category->published_letter_types_count }} surat
                            @else
                                Surat pertama segera hadir
                            @endif
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-layouts.app>
