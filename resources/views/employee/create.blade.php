<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Tambah Karyawan
                    </h1>

                    <form action="{{ route('employee.store') }}" method="POST">
                        @csrf
                        <div class="mt-4 text-gray-500">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="name" value="{{ __('Nama Karyawan') }}" />
                                <x-input id="name" name="name" type="text" class="mt-1 block w-2/4" autofocus required />
                                <x-input-error for="name" class="mt-2" />
                            </div>
                        </div>
                        @foreach ($criteria as $cr)
                        <div class="mt-4 text-gray-500">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="criteria[{{$cr['id']}}]" value="{{ __($cr['name']) }}" />
                                <x-input id="criteria[{{$cr['id']}}]" name="criteria[{{$cr['id']}}]" type="number" step="0.01" class="mt-1 block w-2/4" required />
                                <x-input-error for="criteria[{{$cr['id']}}]" class="mt-2" />
                            </div>
                        </div>
                        @endforeach

                        <div class="mt-4 text-gray-500">
                            <x-buttons.primary class="text-xs">
                                {{ __('Simpan') }}
                            </x-buttons.primary>
                            <a href="{{ route('employee.index') }}">
                                <x-buttons.secondary type="button">
                                    {{ __('Kembali') }}
                                </x-buttons.primary>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
