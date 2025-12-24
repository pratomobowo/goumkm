<x-app-layout>
    <x-slot name="header">
        Kalkulasi Pajak {{ $year }}
    </x-slot>

    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Kalkulasi Pajak Tahun {{ $year }}</h2>
            <p class="text-sm text-gray-500">Rincian pajak per bulan</p>
        </div>

        <!-- Annual Summary -->
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Status Pajak Tahunan</p>
                    <p class="text-xl font-bold text-purple-900 mt-1">{{ $annualTax['tax_status']->label() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-purple-700">Total Pajak Terutang</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">Rp {{ number_format($annualTax['tax_amount'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Monthly Breakdown -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Omzet</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tarif</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pajak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    @endphp
                    @foreach($monthlyTaxes as $index => $tax)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $months[$index] }}</td>
                            <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($tax['gross_revenue'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $tax['tax_rate'] * 100 }}%</td>
                            <td class="px-4 py-3 text-sm text-right font-medium">Rp {{ number_format($tax['tax_amount'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">Total</td>
                        <td class="px-4 py-3 text-sm text-right font-semibold">Rp {{ number_format($annualTax['gross_revenue'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3 text-sm text-right font-bold text-purple-700">Rp {{ number_format($annualTax['tax_amount'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('tax.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
