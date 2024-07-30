<table class="w-full whitespace-nowrap">
    <thead>
        <tr tabindex="0" class="focus:outline-none h-16 border border-gray-100 rounded">
            @foreach ($header as $h)
            <td>{{ $h }}</td>
            @endforeach
            @if (count($action) > 0)
            <td align="center">Aksi</td>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($record as $key => $result)
            <tr tabindex="0" class="focus:outline-none h-16 border border-gray-100 rounded">
                @foreach (collect($result)->except(['id', 'created_at', 'updated_at']) as $k => $r)
                <td class="">
                    <div class="flex items-center">
                        <p class="text-base font-medium leading-none text-gray-700">{{ $result[$k] }}</p>
                    </div>
                </td>
                @endforeach
                @if (count($action) > 0)
                <td align="center">
                    @isset ($action['edit'])
                    <a href="{{ route($action['edit'] . '.edit', $result) }}">
                        <x-buttons.primary class="text-xs">
                            Ubah
                        </x-buttons.primary>
                    </a>
                    @endisset
                    @isset ($action['delete'])
                    <form method="POST" action="{{ route($action['delete'] . '.destroy', $result) }}" class="inline">
                        @method('DELETE')
                        @csrf
                        <x-buttons.danger onclick="return confirm('Yakin ingin hapus?')" class="text-xs">
                           Hapus
                        </x-buttons.danger>
                    </form>
                    @endisset
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
