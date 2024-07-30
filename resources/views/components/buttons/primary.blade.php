<button
  {{ $attributes->merge(['type' => 'submit', 'class' => 'middle none center rounded-lg bg-blue-500 py-3 px-6 font-sans font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none']) }}
>
    {{ $slot }}
</button>