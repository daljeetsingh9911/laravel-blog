<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            <span>
                {{ __('Here are your articles ')}}
            </span>
            <span class="block inline text-xs text-white transition-all hover:text-gray-100 font-bold pr-2 uppercase">
                <a href="{{ route('articles.create') }}" class="bg-red-700 rounded-md py-1 px-3">
                    Create Article
                </a>
            </span>
        </h2>
        
    </x-slot>

    @forelse ($articles as $article) 
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="sm:float-right float-left sm:pt-20 text-gray-400">
                            {{ $article->created_at->format("M jS Y") }}
                            , by {{ $article->user->name }}
                        </span>
            
                        <a href="{{ route('articles.show', $article->slug) }}">
                            <h2 class="hover:text-red-700 sm:w-3/5 transition-all text-white sm:pt-0 pt-10 text-3xl sm:text-4xl font-bold sm:pb-2 w-full sm:pt-10 block">
                                {{ $article->name }}
                            </h2>
                        </a>
            
                        <p class="text-gray-400 leading-8 py-6 text-lg w-full sm:w-3/5">
                            {{ $article->excerpt }}
                        </p>
            
                        @foreach($article->tags as $tag)
                            <span class="block inline text-xs text-white transition-all hover:text-gray-100 font-bold pr-2 uppercase">
                                <a href="/" class="bg-red-700 rounded-md py-1 px-3">
                                    {{ $tag->name }}
                                </a>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @empty
            <h2 class="hover:text-red-700 sm:w-3/5 transition-all text-white sm:pt-0 pt-10 text-3xl sm:text-4xl font-bold sm:pb-2 w-full block">
                You do not have any Article yet
            </h2>
    @endforelse

    <div class="py-20">
        {{ $articles->links() }}
    </div>
</x-app-layout>
