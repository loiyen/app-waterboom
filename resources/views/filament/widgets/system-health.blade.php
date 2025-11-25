<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-3">
            <h1 class="font-semibold">System Healt</h1>
        </div>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="p-3 rounded-lg bg-green-50 border">
                <p class="text-sm text-gray-600">Database Status</p>
                <p class="font-semibold">{{ $dbStatus }}</p>
            </div>

            <div class="p-3 rounded-lg bg-blue-50 border">
                <p class="text-sm text-gray-600">Storage Usage</p>
                <p class="font-semibold">{{ $storageUsage }}%</p>
            </div>

            <div class="p-3 rounded-lg bg-yellow-50 border">
                <p class="text-sm text-gray-600">Server Time</p>
                <p class="font-semibold">{{ now()->format('d M Y H:i:s') }}</p>
            </div>
        </div>

        @if (!empty($errors))
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Recent Error Logs:</p>
                <div class="bg-gray-900 text-gray-200 text-xs p-3 rounded-md overflow-auto max-h-48">
                    @foreach ($errors as $line)
                        <pre>{{ $line }}</pre>
                    @endforeach
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
