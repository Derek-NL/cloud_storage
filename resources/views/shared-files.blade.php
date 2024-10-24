<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Shared Files') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 mt-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Shared files with you</h3>
        @if($sharedFiles->isEmpty())
            <p class="text-gray-600">No files have been shared with you at the moment.</p>
        @else
            <ul>
                @foreach ($sharedFiles as $sharedFile)
                    <li class="py-2 border-b flex justify-between items-center">
                        <span>{{ $sharedFile->file->filename }} (Shared by: {{ $sharedFile->user->name }})</span>
                        <span class="text-gray-500 text-sm">{{ $sharedFile->created_at->diffForHumans() }}</span>
                        <a href="{{ route('files.shared.download', $sharedFile->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">Download</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
