@php
$package = (new App\Http\Resources\PackageResource($package))->toArray($package);
$package['accent'] = app(App\Colors::class)->nextColor();
@endphp
<div class="flex m-2 mb-4 shadow hover:shadow-md h-128 w-full max-w-xs rounded" wire:key="{{ $context ?? 'no-context' }}-{{ $package['id'] }}">
    <div style="border: 1px solid #ddd; border-top-width: 4px; border-top-color: {{ $package['accent'] }}" class="flex-1 bg-white text-sm rounded">
        @if (optional(auth()->user())->isAdmin())
            <div class="text-right -mb-6">
                <div class="relative" x-data="{ open: false }">
                    <div role="button" class="inline-block select-none p-2" @click="open = !open">
                        <span class="appearance-none flex items-center inline-block text-white font-medium">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </span>
                    </div>
                    <div class="absolute right-0 w-auto mr-2 z-50" x-show="open">
                        <div class="bg-indigo shadow rounded border overflow-hidden" x-cloak>
                            @if ($package['is_disabled'])
                                <a href="{{ route('app.admin.enable-package', $package['id']) }}" class="no-underline block px-4 py-3 border-b text-white bg-indigo-500 hover:text-white hover:bg-blue-500">
                                    Enable
                                </a>
                            @else
                                <a href="{{ route('app.admin.disable-package', $package['id']) }}" class="no-underline block px-4 py-3 border-b text-white bg-indigo-500 hover:text-white hover:bg-blue-500">
                                    Disable
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-row mt-4 px-4 pb-4" style="height: 14em">
            <div class="pb-2 w-full relative">
                <a href="{{ route('packages.show', ['namespace' => $package['packagist_namespace'], 'name' => $package['packagist_name']]) }}" class="block mb-2 no-underline">
                    <h2 class="text-xl font-bold text-gray-800 flex flex-row items-center">
                        @include('livewire.partials.title-icon', [
                            'color' => $package['accent'],
                            'size' => 'small',
                            'title' => str_replace(['Laravel Nova ', 'Nova '], [], $package['name']),
                        ])
                        {{ str_replace(['Laravel Nova ', 'Nova '], [], $package['name']) }}

                        @if ($package['is_disabled'])
                            <span class="text-xs uppercase text-gray-400">Disabled</span>
                        @endif
                    </h2>
                </a>

                <div class="flex flex-row absolute bottom-0 right-0">
                    <div class="flex">
                        @include('partials.stars', ['stars' => $package['average_rating']])
                    </div>

                    <div class="flex text-gray-500 pt-1 pl-1 text-xs">
                        ({{ $package['rating_count'] }})
                    </div>
                </div>

                <div class="text-gray-800 leading-normal mb-4 markdown leading-tight w-full" style="word-break: break-word;">
                    {!! $package['abstract'] !!}
                </div>

                <a href="{{ route('packages.show', ['namespace' => $package['packagist_namespace'], 'name' => $package['packagist_name']]) }}" class="absolute block text-indigo-600 font-bold no-underline bottom-0 left-0">
                    Learn More
                </a>
            </div>
        </div>
        <div class="bg-gray-100 flex justify-between border-t border-gray-300 px-4 py-4 items-center rounded-b">
            <div class="flex items-center text-sm">
                <img src="{{ $package['author']['avatar_url'] }}" class="rounded-full h-6 w-6 mr-4" alt="{{ $package['author']['name'] }}"/>
                <a href="/collaborators/{{ $package['author']['github_username'] }}" class="text-indigo-600 font-bold no-underline uppercase text-xs hover:text-indigo-700">
                    {{ $package['author']['name'] }}
                </a>
            </div>
            @if (true)
                <div>
                    <div class="flex items-center justify-center">
                        <div class="relative inline-flex" x-data="{ tooltip: true }">
                            <div class="rounded-md cursor-pointer" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                <svg
                                    viewBox="0 0 20 20"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    class="fill-current h-4 w-4"
                                >
                                    <g stroke="none" stroke-width="1" fill="fill-current" fill-rule="evenodd">
                                        <g>
                                            <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="relative" x-cloak x-show="tooltip">
                                <div class="absolute top-0 z-10 w-32 p-3 -mt-1 leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-red-600 rounded-lg shadow-lg">
                                    This package is possibly abandoned.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
