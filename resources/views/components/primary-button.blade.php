<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-marca-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-marca-700 focus:bg-marca-700 active:bg-marca-800 focus:outline-none focus:ring-2 focus:ring-marca-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
