<x-app-layout>
    <x-slot name="header">
        Detail Anggaran
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">{{ $budget->name }}</h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $budget->type->value === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $budget->type->label() }}
                </span>
            </div>

            <dl class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Periode</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $budget->period_month }}/{{ $budget->period_year }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Anggaran</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($budget->planned_amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Realisasi</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($budget->realization, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm text-gray-500">Persentase</dt>
                    <dd class="text-sm font-bold {{ $budget->percentage > 100 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($budget->percentage, 1) }}%</dd>
                </div>
            </dl>

            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full {{ $budget->percentage > 100 ? 'bg-red-500' : 'bg-blue-500' }}"
                         style="width: {{ min($budget->percentage, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('budgets.edit', $budget) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('budgets.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
