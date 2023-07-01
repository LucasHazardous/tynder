<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg h-[500px]">
            @if(empty($messages))
                @foreach ($users as $user)
                <a href="{{route('chat')}}/{{$user->id}}">
                    <div class="p-3 border-solid border-2 border-indigo-800 rounded-md mb-3">
                        <img class="inline-block mr-4 rounded-full" src="storage/{{$user->avatar}}" alt="user avatar" width="40">
                        <p class="inline-block text-lg font-medium text-gray-900 dark:text-gray-100">{{$user->name}}</p>
                    </div>
                </a>
                @endforeach
            @else
                @foreach ($messages as $message)
                <div class="p-3 border-solid border-2 {{ $message->sender === auth()->user()->id ? 'border-indigo-800' : 'border-indigo-500' }} rounded-md mb-3">
                    <p class="inline-block text-lg font-medium text-gray-900 dark:text-gray-100">{{$message->content}}</p>
                </div>
                @endforeach
                <div class="p-3 border-solid border-2 border-indigo-800 rounded-md mb-3">
                    <form action="{{route('chat.message.send')}}" method="post">
                        @csrf
                        <input type="hidden" name="receiver" id="receiver" value="{{$receiver}}">
                        <x-text-input class="min-w-[250px]" type="text" name="content" id="content" maxlength="255" minlength="2" required autofocus />
                        <x-primary-button class="float-right">{{ __('Save') }}</x-primary-button>
                    </form>
                </div>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
