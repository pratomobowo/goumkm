<x-app-layout>
    <x-slot name="header">
        Pajak
    </x-slot>

    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Kalkulator Pajak UMKM</h2>
            <p class="text-sm text-gray-500">Tahun {{ $currentYear }}</p>
        </div>

        @if($annualTax)
        <!-- Tax Status Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Status Pajak Anda</h3>
                    <p class="text-2xl font-bold text-purple-600 mt-2">{{ $annualTax['tax_status']->label() }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $annualTax['tax_status']->description() }}</p>
                </div>
            </div>
        </div>

        <!-- Annual Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Omzet Tahunan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($annualTax['gross_revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Tarif Pajak</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $annualTax['tax_rate'] * 100 }}%</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Estimasi Pajak Tahunan</p>
                <p class="text-2xl font-bold text-purple-600 mt-1">Rp {{ number_format($annualTax['tax_amount'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-800">Ketentuan PP 55/2022</h4>
                    <ul class="text-sm text-blue-700 mt-1 space-y-1">
                        <li>• Omzet ≤ Rp 500 juta/tahun: <strong>Bebas PPh</strong></li>
                        <li>• Omzet > Rp 500 juta s.d. Rp 4.8 miliar: <strong>PPh Final 0.5%</strong></li>
                        <li>• Omzet > Rp 4.8 miliar: <strong>Wajib PKP (PPN 11%)</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        @else
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                <p class="text-gray-500">Anda belum memiliki usaha terdaftar</p>
            </div>
        @endif
    </div>
</x-app-layout>
