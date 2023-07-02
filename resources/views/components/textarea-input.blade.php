@props(['disabled' => false, 'message'])

<textarea rows="5" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'resize-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm']) !!}>
{{ $message }}</textarea>