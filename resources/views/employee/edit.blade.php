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
                        Ubah Kriteria
                    </h1>

                    <form action="{{ route('employee.update', $employee['id']) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mt-4 text-gray-500">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="name" value="{{ __('Nama Karyawan') }}" />
                                <x-input id="name" type="text" class="mt-1 block w-2/4" name="name" value="{{ $employee['name'] }}" autofocus required />
                                <x-input-error for="name" class="mt-2" />
                            </div>
                        </div>
                        @foreach ($employee['alternate'] as $key => $alternate)
                        <div class="mt-4 text-gray-500">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="criteria[{{ $key }}]" value="{{ __($alternate['name']) }}" />
                                <x-input id="criteria[{{ $key }}]" name="criteria[{{ $key }}]" value="{{ $alternate['value'] }}" type="number" step="0.01" class="mt-1 block w-2/4" required />
                                <x-input-error for="criteria[{{ $key }}]" class="mt-2" />
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
