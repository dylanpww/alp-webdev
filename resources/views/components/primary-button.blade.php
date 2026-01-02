<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
    'style' => 'background-color: #BA8B4E; border-color: #BA8B4E;'
]) }}>
    {{ $slot }}
</button>