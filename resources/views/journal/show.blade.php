<x-app-layout>
    <x-slot name="header">
        Detail Jurnal
    </x-slot>

    <div class="max-w-4xl space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $journal->entry_number }}</h2>
                    <p class="text-sm text-gray-500">{{ $journal->date->format('d F Y') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $journal->is_posted ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $journal->is_posted ? 'Posted' : 'Draft' }}
                </span>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-500">Keterangan</p>
                <p class="text-gray-900">{{ $journal->description }}</p>
                @if($journal->notes)
                    <p class="text-sm text-gray-500 mt-2">{{ $journal->notes }}</p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-y border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Akun</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Kredit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($journal->lines as $line)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $line->account->code }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $line->account->name }}
                                    @if($line->memo)
                                        <span class="text-gray-400 text-xs block">{{ $line->memo }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-medium">
                                    {{ $line->debit > 0 ? 'Rp ' . number_format($line->debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-medium">
                                    {{ $line->credit > 0 ? 'Rp ' . number_format($line->credit, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-sm font-semibold text-gray-700">Total</td>
                            <td class="px-4 py-3 text-sm text-right font-bold text-gray-900">Rp {{ number_format($journal->getTotalDebit(), 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right font-bold text-gray-900">Rp {{ number_format($journal->getTotalCredit(), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 text-sm text-gray-500">
                Dibuat oleh: {{ $journal->user->name }} • {{ $journal->created_at->format('d M Y H:i') }}
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('journal.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
            <form action="{{ route('journal.destroy', $journal) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-red-600 rounded-lg hover:bg-red-50">Hapus</button>
            </form>
        </div>
    </div>
</x-app-layout>
