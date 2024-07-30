<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'middle none center rounded-lg py-3 px-6 font-sans border-gray-300 text-gray-700 text-xs font-bold uppercase shadow-md shadow-grey-500/20 transition-all hover:shadow-lg hover:shadow-grey-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none']) }}
    >
    {{ $slot }}
</button>
