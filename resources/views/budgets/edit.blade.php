<x-app-layout>
    <x-slot name="header">
        Edit Anggaran
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('budgets.update', $budget) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Anggaran</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $budget->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">Periode: <span class="font-semibold">{{ $budget->period_month }}/{{ $budget->period_year }}</span></p>
                        <p class="text-xs text-gray-400 mt-1">Periode tidak dapat diubah</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="income" {{ $budget->type->value === 'income' ? 'checked' : '' }} class="text-blue-600">
                                <span class="text-sm text-gray-700">Pemasukan</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="expense" {{ $budget->type->value === 'expense' ? 'checked' : '' }} class="text-blue-600">
                                <span class="text-sm text-gray-700">Pengeluaran</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="planned_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Anggaran (Rp)</label>
                        <input type="number" id="planned_amount" name="planned_amount" value="{{ old('planned_amount', $budget->planned_amount) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex justify-between text-sm">
                            <span class="text-blue-700">Realisasi saat ini:</span>
                            <span class="font-semibold text-blue-800">Rp {{ number_format($budget->realization, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-blue-700">Persentase:</span>
                            <span class="font-semibold {{ $budget->percentage > 100 ? 'text-red-600' : 'text-blue-800' }}">{{ number_format($budget->percentage, 1) }}%</span>
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea id="notes" name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('notes', $budget->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Simpan</button>
                    <a href="{{ route('budgets.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
