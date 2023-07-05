<section class="space-y-6 p-5">
    @if (is_null($user))
        <p class="mt-1 mr-2 text-xs text-gray-600 dark:text-gray-400">
            Wow, you reviewed everyone...
        </p>
    @else
        <div class="max-w-sm rounded overflow-hidden shadow-2xl">
            <img class="w-full" src="/storage/{{$user->avatar}}" alt="user avatar">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2 text-gray-900 dark:text-gray-100">{{$user->name}}</div>
                <p class="text-gray-700 text-base text-gray-600 dark:text-gray-400">
                    {{$user->description}}
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Joined {{$user->created_at->year}}</span>
                <span class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{is_null($user->email_verified_at) ? 'Unverified' : 'Verified'}}</span>
            </div>
            <div class="px-6 pt-4 pb-2">
                <x-secondary-button
                    x-data=""
                    onclick="makeGoodRelation(1);"
                >{{ __('Like') }}</x-secondary-button>
                <x-secondary-button
                    x-data=""
                    onclick="makeGoodRelation(0);"
                >{{ __('Dislike') }}</x-secondary-button>
            </div>
        </div>

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
    @endif
</section>
