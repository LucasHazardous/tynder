<section class="space-y-6 p-5">
    @if (is_null($user))
        <p class="mt-1 mr-2 text-xs text-gray-600 dark:text-gray-400">
            Wow, you reviewed everyone...
        </p>
    @else
        <header class="w-[300px]">
            <img src="/storage/{{$user->avatar}}" alt="user avatar" class="rounded max-w-[100%]">

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

        <form class="hidden" id="relationForm" method="post" action="{{route('createRelation')}}">
            @csrf
            <input name="target_id" id="target_id" type="hidden" value="{{$user->id}}">
            <input name="likes" id="likes" type="hidden">
        </form>

        <script defer>
            function makeGoodRelation(likes) {
                document.getElementById('likes').value=likes;
                document.getElementById('relationForm').submit();
            }
        </script>

        <x-secondary-button
            x-data=""
            onclick="makeGoodRelation(1);"
        >{{ __('Like') }}</x-secondary-button>
        <x-secondary-button
            x-data=""
            onclick="makeGoodRelation(0);"
        >{{ __('Dislike') }}</x-secondary-button>
    @endif
</section>
