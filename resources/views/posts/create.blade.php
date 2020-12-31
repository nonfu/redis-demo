<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            发布新文章
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="/posts/store" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-label for="title" value="标题" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="Image" value="封面图片" />

                            <x-input id="image" class="block mt-1 w-full" type="file" name="image" required autofocus />
                        </div>


                        <div class="mt-4">
                            <x-label for="content" value="内容" />

                            <x-textarea id="content" class="block mt-1 w-full" name="content" rows="5" :value="old('content')" required/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                立即发布
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
