<x-app-layout>
    <x-slot name="header">
        Arus Kas
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Laporan Arus Kas</h2>
                <p class="text-sm text-gray-500">Periode: {{ $month }}/{{ $year }}</p>
            </div>
        </div>

        @if($cashflow)
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Pemasukan</p>
                <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($cashflow['total_income'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($cashflow['total_expense'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Arus Kas Bersih</p>
                <p class="text-2xl font-bold {{ $cashflow['is_positive'] ? 'text-green-600' : 'text-red-600' }} mt-1">
                    Rp {{ number_format($cashflow['net_cashflow'], 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Income Breakdown -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemasukan per Kategori</h3>
                <div class="space-y-3">
                    @forelse($cashflow['income_breakdown'] as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $item['category'] }}</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengeluaran per Kategori</h3>
                <div class="space-y-3">
                    @forelse($cashflow['expense_breakdown'] as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $item['category'] }}</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                <p class="text-gray-500">Anda belum memiliki usaha terdaftar</p>
            </div>
        @endif

        <!-- Trend Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren 12 Bulan</h3>
            <div id="trend-chart" class="h-64"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const trendData = @json($trend);
        
        new ApexCharts(document.querySelector("#trend-chart"), {
            series: [{
                name: 'Arus Kas Bersih',
                data: trendData.map(d => d.net)
            }],
            chart: { type: 'area', height: 250, toolbar: { show: false } },
            colors: ['#3b82f6'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.1 } },
            xaxis: { categories: trendData.map(d => d.month) },
            yaxis: { labels: { formatter: (val) => 'Rp ' + (val / 1000000).toFixed(1) + 'jt' } }
        }).render();
    </script>
    @endpush
</x-app-layout>
