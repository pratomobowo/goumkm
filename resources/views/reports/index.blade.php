<x-app-layout>
    <x-slot name="header">
        Laporan
    </x-slot>

    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Laporan Keuangan</h2>
            <p class="text-sm text-gray-500">Pilih jenis laporan yang ingin Anda lihat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Profit/Loss Report -->
            <a href="{{ route('reports.income-statement') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Laporan Laba/Rugi</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat ringkasan pendapatan dan pengeluaran</p>
            </a>

            <!-- Cashflow Report -->
            <a href="{{ route('cashflow.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Laporan Arus Kas</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat aliran kas masuk dan keluar</p>
            </a>

            <!-- Budget Report -->
            <a href="{{ route('budgets.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Laporan Budget</h3>
                <p class="text-sm text-gray-500 mt-1">Bandingkan rencana vs realisasi</p>
            </a>

            <!-- Tax Report -->
            <a href="{{ route('tax.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Rekap Pajak</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat kalkulasi pajak UMKM</p>
            </a>

            <!-- Export PDF -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 opacity-75">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Export PDF</h3>
                <p class="text-sm text-gray-500 mt-1">Unduh laporan dalam format PDF</p>
                <span class="inline-block mt-2 text-xs text-gray-400">(Segera hadir)</span>
            </div>

            <!-- Export Excel -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 opacity-75">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Export Excel</h3>
                <p class="text-sm text-gray-500 mt-1">Unduh laporan dalam format Excel</p>
                <span class="inline-block mt-2 text-xs text-gray-400">(Segera hadir)</span>
            </div>
        </div>
    </div>
</x-app-layout>
