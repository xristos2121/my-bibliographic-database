<select  {!! $attributes->merge([
            'class' => 'px-4 py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 block mt-1 w-full',
        ])
    !!}>
    {{ $slot }}
</select>
