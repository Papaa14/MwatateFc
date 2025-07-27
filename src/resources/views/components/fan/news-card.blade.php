@props(['article'])

<div class="flex flex-col overflow-hidden bg-white rounded-lg shadow-lg">
    <div class="flex-shrink-0">
        <img class="object-cover w-full h-48" src="{{ $article->image_url }}" alt="{{ $article->title }}">
    </div>
    <div class="flex flex-col justify-between flex-1 p-6">
        <div class="flex-1">
            <p class="text-sm font-medium text-blue-600">
                <a href="#" class="hover:underline">
                    {{ $article->category }}
                </a>
            </p>
            <a href="{{ route('news.show', $article->slug) }}" class="block mt-2">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $article->title }}
                </h3>
                <p class="mt-3 text-base text-gray-500">
                    {{ Str::limit($article->excerpt, 150) }}
                </p>
            </a>
        </div>
        <div class="flex items-center mt-6">
            <div class="flex-shrink-0">
                <img class="w-10 h-10 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">
                    <a href="#" class="hover:underline">
                        {{ $article->author->name }}
                    </a>
                </p>
                <div class="flex space-x-1 text-sm text-gray-500">
                    <time datetime="{{ $article->published_at->toDateString() }}">
                        {{ $article->published_at->format('M d, Y') }}
                    </time>
                    <span aria-hidden="true">&middot;</span>
                    <span>{{ $article->read_time }} min read</span>
                </div>
            </div>
        </div>
    </div>
</div>