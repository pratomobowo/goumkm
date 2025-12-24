<x-app-layout>
    <x-slot name="header">
        Buku Besar
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Buku Besar</h2>
                <p class="text-sm text-gray-500">Ringkasan saldo akun (Chart of Accounts)</p>
            </div>
            <a href="{{ route('journal.index') }}" class="text-sm text-blue-600 hover:text-blue-700">← Kembali ke Jurnal</a>
        </div>

        @php
            $typeLabels = [
                'asset' => ['label' => 'ASET', 'color' => 'blue'],
                'liability' => ['label' => 'KEWAJIBAN', 'color' => 'red'],
                'equity' => ['label' => 'MODAL', 'color' => 'purple'],
                'income' => ['label' => 'PENDAPATAN', 'color' => 'green'],
                'expense' => ['label' => 'BEBAN', 'color' => 'orange'],
            ];
        @endphp

        @foreach($accounts as $type => $accs)
            @php $info = $typeLabels[$type] ?? ['label' => $type, 'color' => 'gray']; @endphp
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-3 bg-{{ $info['color'] }}-50 border-b border-{{ $info['color'] }}-100">
                    <h3 class="font-semibold text-{{ $info['color'] }}-800">{{ $info['label'] }}</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="width: 15%">Kode</th>
                            <th class="px-5 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Akun</th>
                            <th class="px-5 py-2 text-right text-xs font-medium text-gray-500 uppercase" style="width: 25%">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($accs as $account)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 text-sm font-medium text-gray-600">{{ $account->code }}</td>
                                <td class="px-5 py-3 text-sm text-gray-900">{{ $account->name }}</td>
                                <td class="px-5 py-3 text-sm text-right font-medium {{ $account->balance >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                                    Rp {{ number_format(abs($account->balance), 0, ',', '.') }}
                                    @if($account->balance < 0) <span class="text-xs">(Cr)</span> @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-200">
                        <tr>
                            <td colspan="2" class="px-5 py-2 text-sm font-semibold text-gray-700">Subtotal {{ $info['label'] }}</td>
                            <td class="px-5 py-2 text-sm text-right font-bold text-gray-900">
                                Rp {{ number_format($accs->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
    </div>
</x-app-layout>
