<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 mt-6 bg-white rounded-lg shadow-lg">

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-gray-700 text-lg font-semibold mb-2">Choose file:</label>
                <input type="file" name="file" id="file" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="text-center">
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">
                    Upload
                </button>
            </div>
        </form>

        <h3 class="text-xl font-semibold mb-4">Uploaded Files</h3>
        <ul class="space-y-4">
            @foreach ($files as $file)
                <li class="flex flex-col sm:flex-row justify-between items-center p-4 bg-gray-100 rounded-lg shadow hover:bg-gray-200 transition duration-200">
                    <span class="text-gray-800 mb-2 sm:mb-0">{{ $file->filename }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('files.download', $file->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">Download</a>
                        <form method="POST" action="{{ route('files.delete', $file->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">Delete</button>
                        </form>
                        <button onclick="openShareModal('{{ $file->id }}')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-transparent hover:bg-blue-100 rounded-lg transition duration-200">Deel</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Modal voor Delen -->
    <div id="shareModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg p-6 w-80">
            <h3 class="text-lg font-semibold mb-4">Deel bestand</h3>
            <form id="shareForm" action="" method="POST">
                @csrf
                <div class="flex items-center space-x-2">
                    <input type="text" name="username" placeholder="Voer gebruikersnaam in" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Deel</button>
                </div>
            </form>
            <button onclick="closeShareModal()" class="mt-4 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Sluiten</button>
        </div>
    </div>

    <script>
        function openShareModal(fileId) {
            // Set the action URL for the share form
            document.getElementById('shareForm').action = "{{ url('files/share') }}" + "/" + fileId; // Correcte URL
            // Open de modal
            document.getElementById('shareModal').classList.remove('hidden');
        }

        function closeShareModal() {
            // Sluit de modal
            document.getElementById('shareModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
