<x-app-layout>
    <x-slot name="header">
        Buat Jurnal
    </x-slot>

    <div class="max-w-4xl">
        @if($errors->has('balance'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-700">{{ $errors->first('balance') }}</p>
            </div>
        @endif

        <form action="{{ route('journal.store') }}" method="POST" id="journal-form">
            @csrf

            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Jurnal</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}" required
                               placeholder="Contoh: Penerimaan kas dari penjualan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Baris Jurnal</h3>
                    <button type="button" onclick="addLine()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        + Tambah Baris
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" id="journal-lines">
                        <thead class="border-b border-gray-200">
                            <tr>
                                <th class="pb-3 text-left text-xs font-medium text-gray-500 uppercase" style="width: 40%">Akun</th>
                                <th class="pb-3 text-right text-xs font-medium text-gray-500 uppercase" style="width: 20%">Debit</th>
                                <th class="pb-3 text-right text-xs font-medium text-gray-500 uppercase" style="width: 20%">Kredit</th>
                                <th class="pb-3 text-left text-xs font-medium text-gray-500 uppercase" style="width: 15%">Memo</th>
                                <th class="pb-3" style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody id="lines-container">
                            <!-- Line 1 - Debit -->
                            <tr class="journal-line">
                                <td class="py-2 pr-2">
                                    <select name="lines[0][account_id]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        <option value="">Pilih akun...</option>
                                        @foreach($accounts as $type => $accs)
                                            <optgroup label="{{ ucfirst($type) }}">
                                                @foreach($accs as $acc)
                                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2 px-2">
                                    <input type="number" name="lines[0][debit]" value="0" min="0" step="1000"
                                           onchange="calculateTotals()"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right debit-input">
                                </td>
                                <td class="py-2 px-2">
                                    <input type="number" name="lines[0][credit]" value="0" min="0" step="1000"
                                           onchange="calculateTotals()"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right credit-input">
                                </td>
                                <td class="py-2 px-2">
                                    <input type="text" name="lines[0][memo]" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </td>
                                <td class="py-2 pl-2"></td>
                            </tr>
                            <!-- Line 2 - Credit -->
                            <tr class="journal-line">
                                <td class="py-2 pr-2">
                                    <select name="lines[1][account_id]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        <option value="">Pilih akun...</option>
                                        @foreach($accounts as $type => $accs)
                                            <optgroup label="{{ ucfirst($type) }}">
                                                @foreach($accs as $acc)
                                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2 px-2">
                                    <input type="number" name="lines[1][debit]" value="0" min="0" step="1000"
                                           onchange="calculateTotals()"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right debit-input">
                                </td>
                                <td class="py-2 px-2">
                                    <input type="number" name="lines[1][credit]" value="0" min="0" step="1000"
                                           onchange="calculateTotals()"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right credit-input">
                                </td>
                                <td class="py-2 px-2">
                                    <input type="text" name="lines[1][memo]" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </td>
                                <td class="py-2 pl-2"></td>
                            </tr>
                        </tbody>
                        <tfoot class="border-t-2 border-gray-300">
                            <tr>
                                <td class="py-3 text-sm font-semibold text-gray-700">Total</td>
                                <td class="py-3 text-right">
                                    <span id="total-debit" class="text-sm font-bold text-gray-900">Rp 0</span>
                                </td>
                                <td class="py-3 text-right">
                                    <span id="total-credit" class="text-sm font-bold text-gray-900">Rp 0</span>
                                </td>
                                <td colspan="2" class="py-3">
                                    <span id="balance-status" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">Belum seimbang</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" id="submit-btn" disabled
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Jurnal
                </button>
                <a href="{{ route('journal.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Batal</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let lineIndex = 2;
        const accountOptions = `@foreach($accounts as $type => $accs)<optgroup label="{{ ucfirst($type) }}">@foreach($accs as $acc)<option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>@endforeach</optgroup>@endforeach`;

        function addLine() {
            const container = document.getElementById('lines-container');
            const row = document.createElement('tr');
            row.className = 'journal-line';
            row.innerHTML = `
                <td class="py-2 pr-2">
                    <select name="lines[${lineIndex}][account_id]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Pilih akun...</option>
                        ${accountOptions}
                    </select>
                </td>
                <td class="py-2 px-2">
                    <input type="number" name="lines[${lineIndex}][debit]" value="0" min="0" step="1000"
                           onchange="calculateTotals()"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right debit-input">
                </td>
                <td class="py-2 px-2">
                    <input type="number" name="lines[${lineIndex}][credit]" value="0" min="0" step="1000"
                           onchange="calculateTotals()"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-right credit-input">
                </td>
                <td class="py-2 px-2">
                    <input type="text" name="lines[${lineIndex}][memo]" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </td>
                <td class="py-2 pl-2">
                    <button type="button" onclick="removeLine(this)" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            `;
            container.appendChild(row);
            lineIndex++;
        }

        function removeLine(btn) {
            const row = btn.closest('tr');
            row.remove();
            calculateTotals();
        }

        function calculateTotals() {
            const debits = document.querySelectorAll('.debit-input');
            const credits = document.querySelectorAll('.credit-input');
            
            let totalDebit = 0;
            let totalCredit = 0;

            debits.forEach(input => totalDebit += parseFloat(input.value) || 0);
            credits.forEach(input => totalCredit += parseFloat(input.value) || 0);

            document.getElementById('total-debit').textContent = 'Rp ' + totalDebit.toLocaleString('id-ID');
            document.getElementById('total-credit').textContent = 'Rp ' + totalCredit.toLocaleString('id-ID');

            const balanceStatus = document.getElementById('balance-status');
            const submitBtn = document.getElementById('submit-btn');

            if (totalDebit === totalCredit && totalDebit > 0) {
                balanceStatus.textContent = '✓ Seimbang';
                balanceStatus.className = 'text-xs px-2 py-1 rounded-full bg-green-100 text-green-700';
                submitBtn.disabled = false;
            } else {
                balanceStatus.textContent = 'Belum seimbang';
                balanceStatus.className = 'text-xs px-2 py-1 rounded-full bg-red-100 text-red-600';
                submitBtn.disabled = true;
            }
        }
    </script>
    @endpush
</x-app-layout>
