<thead
    {{ $attributes->merge([
        'class' => 'text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-xl',
        'scope' => 'col'
    ]) }}>
    {{ $slot }}
</thead>
