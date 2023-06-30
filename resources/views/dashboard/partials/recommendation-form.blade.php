<section class="space-y-6 p-5 ml-[30%]">
    <header>
        <img src="/storage/{{$user->avatar}}" alt="user avatar" class="rounded w-[50%]">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 inline-block">
            {{$user->name}}
        </h2>

        <p class="mt-1 ml-1 inline-block text-xs text-gray-600 dark:text-gray-400">
            Joined {{$user->created_at->year}}
        </p>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{$user->description}}
        </p>
    </header>

    <x-secondary-button
        x-data=""
    >{{ __('Like') }}</x-secondary-button>
    <x-secondary-button
        x-data=""
    >{{ __('Dislike') }}</x-secondary-button>
</section>
