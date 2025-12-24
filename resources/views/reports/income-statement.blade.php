<x-app-layout>
    <x-slot name="header">
        Laporan Laba/Rugi
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Laporan Laba/Rugi</h2>
                <p class="text-sm text-gray-500">Periode: {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</p>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <select name="month" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900" colspan="2">Keterangan</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- PENDAPATAN -->
                    <tr class="bg-green-50">
                        <td class="px-4 py-3 text-sm font-semibold text-green-800" colspan="2">PENDAPATAN</td>
                        <td></td>
                    </tr>
                    @forelse($incomeData as $category => $amount)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-600 pl-8">{{ $category }}</td>
                            <td></td>
                            <td class="px-4 py-3 text-sm text-right text-gray-900">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-400 pl-8 italic" colspan="2">Tidak ada pendapatan</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-400">-</td>
                        </tr>
                    @endforelse
                    <tr class="bg-green-50">
                        <td class="px-4 py-3 text-sm font-semibold text-green-800" colspan="2">Total Pendapatan</td>
                        <td class="px-4 py-3 text-sm text-right font-bold text-green-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                    </tr>

                    <tr><td colspan="3" class="h-4"></td></tr>

                    <!-- BIAYA -->
                    <tr class="bg-red-50">
                        <td class="px-4 py-3 text-sm font-semibold text-red-800" colspan="2">BIAYA</td>
                        <td></td>
                    </tr>
                    @forelse($expenseData as $category => $amount)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-600 pl-8">{{ $category }}</td>
                            <td></td>
                            <td class="px-4 py-3 text-sm text-right text-gray-900">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-400 pl-8 italic" colspan="2">Tidak ada biaya</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-400">-</td>
                        </tr>
                    @endforelse
                    <tr class="bg-red-50">
                        <td class="px-4 py-3 text-sm font-semibold text-red-800" colspan="2">Total Biaya</td>
                        <td class="px-4 py-3 text-sm text-right font-bold text-red-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                    </tr>

                    <tr><td colspan="3" class="h-4"></td></tr>

                    <!-- LABA/RUGI -->
                    <tr class="bg-blue-100">
                        <td class="px-4 py-4 text-base font-bold text-blue-900" colspan="2">LABA/RUGI BERSIH</td>
                        <td class="px-4 py-4 text-base text-right font-bold {{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            Rp {{ number_format($netProfit, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('reports.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
