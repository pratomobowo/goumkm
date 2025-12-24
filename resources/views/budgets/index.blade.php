<x-app-layout>
    <x-slot name="header">
        Anggaran
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Perencanaan Anggaran</h2>
                <p class="text-sm text-gray-500">Kelola budget bulanan usaha Anda</p>
            </div>
            <a href="{{ route('budgets.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Anggaran
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rencana</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Realisasi</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">%</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($budgets as $budget)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $budget->period_month }}/{{ $budget->period_year }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $budget->name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $budget->type->value === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $budget->type->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($budget->planned_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($budget->realization, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium {{ $budget->percentage > 100 ? 'text-red-600' : 'text-green-600' }}">
                                {{ number_format($budget->percentage, 0) }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada anggaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($budgets->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $budgets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
