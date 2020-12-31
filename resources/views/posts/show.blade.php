<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($post->image_id)
                        <img src="{{ $post->image->url }}">
                    @endif
                    <div>
                        {!! $post->content !!}
                    </div>
                    <hr class="mt-4 mb-4">
                    <x-label>
                        Published by {{ $post->user_id ? $post->user->name : '学院君' }}
                        At {{ $post->created_at }}, Views: {{ $post->views }}
                    </x-label>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
