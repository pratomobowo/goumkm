<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Income -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pemasukan Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($cashflow['total_income'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Expense -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pengeluaran Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($cashflow['total_expense'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Net Cashflow -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Arus Kas Bersih</p>
                        <p class="text-2xl font-bold {{ ($cashflow['net_cashflow'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            Rp {{ number_format($cashflow['net_cashflow'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tax Estimate -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Estimasi Pajak</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($taxEstimate['tax_amount'] ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ $taxEstimate['tax_status']?->label() ?? '-' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Tren Arus Kas (6 Bulan)</h3>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                            Pemasukan
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 bg-rose-500 rounded-full"></span>
                            Pengeluaran
                        </span>
                    </div>
                </div>
                <div id="line-chart" class="h-72"></div>
            </div>

            <!-- Budget Progress -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Realisasi Anggaran</h3>
                <div class="space-y-4">
                    @forelse($budgetSummary as $budget)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ $budget['name'] }}</span>
                                <span class="font-medium">{{ number_format($budget['percentage'], 0) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $budget['percentage'] > 100 ? 'bg-red-500' : 'bg-blue-500' }}"
                                     style="width: {{ min($budget['percentage'], 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada anggaran bulan ini</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Terakhir</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentTransactions as $transaction)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $transaction->isIncome() ? 'bg-green-100' : 'bg-red-100' }}">
                                    <svg class="w-5 h-5 {{ $transaction->isIncome() ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->isIncome() ? 'M7 11l5-5m0 0l5 5m-5-5v12' : 'M17 13l-5 5m0 0l-5-5m5 5V6' }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->description }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->category?->name ?? '-' }} • {{ $transaction->date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold {{ $transaction->isIncome() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->isIncome() ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if(auth()->user()->tenant?->has_inventory)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Stok Menipis</h3>
                    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">Min: {{ $product->min_stock }} {{ $product->unit }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">
                                {{ $product->current_stock }} {{ $product->unit }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Semua stok aman</p>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        const cashflowData = @json($cashflowTrend);
        
        const options = {
            series: [{
                name: 'Pemasukan',
                data: cashflowData.map(d => d.income || 0)
            }, {
                name: 'Pengeluaran',
                data: cashflowData.map(d => d.expense || 0)
            }],
            chart: {
                type: 'line',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#10b981', '#f43f5e'],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 5,
                strokeWidth: 0,
                hover: { size: 7 }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 4
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: cashflowData.map(d => d.month),
                labels: {
                    style: { colors: '#6b7280', fontSize: '12px' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#6b7280', fontSize: '12px' },
                    formatter: (val) => 'Rp ' + (val / 1000000).toFixed(1) + 'jt'
                }
            },
            legend: { show: false },
            tooltip: {
                y: {
                    formatter: (val) => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                }
            }
        };

        new ApexCharts(document.querySelector("#line-chart"), options).render();
    </script>
    @endpush
</x-app-layout>
