<x-app-layout>
    <x-slot name="header">
        Jurnal Umum
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Jurnal Umum</h2>
                <p class="text-sm text-gray-500">Catatan transaksi dengan sistem double-entry</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('journal.ledger') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Buku Besar
                </a>
                <a href="{{ route('journal.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Jurnal
                </a>
            </div>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Jurnal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Kredit</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($journals as $journal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <a href="{{ route('journal.show', $journal) }}" class="text-sm font-medium text-blue-600 hover:underline">
                                    {{ $journal->entry_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $journal->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($journal->description, 40) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium">Rp {{ number_format($journal->getTotalDebit(), 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium">Rp {{ number_format($journal->getTotalCredit(), 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('journal.destroy', $journal) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jurnal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Belum ada jurnal</p>
                                <a href="{{ route('journal.create') }}" class="text-blue-600 hover:underline mt-1 inline-block">Buat jurnal pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($journals->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $journals->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
