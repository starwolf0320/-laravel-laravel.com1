@extends('partials.layout')

@section('content')
    <div class="relative" id="docsScreen">

        <div class="page_contain">
            <div class="lg:flex lg:items-start">
                <aside
                    x-data="{ navIsOpen: false }"
                    class="fixed inset-y-0 left-0 z-20 w-16 flex flex-col pt-8 px-4 bg-gradient-to-b from-gray-100 to-white transition-all duration-300 overflow-x-hidden lg:sticky lg:max-w-lg lg:w-full lg:flex lg:justify-end lg:items-end lg:px-8 lg:shadow-none xl:px-16"
                    :class="{ 'w-64 shadow-lg': navIsOpen }"
                    @click.away="navIsOpen = false"
                    @keydown.window.escape="navIsOpen = false"
                >
                    <div class="flex-1 flex flex-col xl:w-64">
                        <a href="/" class="flex items-center">
                            <img
                                class="w-8 h-8 flex-shrink-0 transition-all duration-300 lg:w-12 lg:h-12"
                                :class="{ 'w-12 h-12': navIsOpen }"
                                src="/img/logomark.min.svg"
                                alt="Laravel"
                            >
                            <img
                                x-show="navIsOpen"
                                x-cloak
                                class="ml-4 transition-all duration-300 lg:hidden"
                                x-transition:enter="duration-250 ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="duration-250 ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                src="/img/logotype.min.svg"
                                alt="Laravel"
                            >
                            <img
                                src="/img/logotype.min.svg"
                                alt="Laravel"
                                class="hidden ml-4 lg:block"
                            >
                        </a>
                        <nav x-show="navIsOpen" class="mt-12 lg:hidden">
                            <div class="docs_sidebar">
                                {!! $index !!}
                            </div>
                        </nav>
                        <nav class="hidden lg:block lg:mt-12">
                            <div class="docs_sidebar">
                                {!! $index !!}
                            </div>
                        </nav>
                        <div :class="{ 'hidden': !navIsOpen }" class="lg:block">
                            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYILK3E&placement=laravelcom" id="_carbonads_js"></script>
                        </div>
                        <div class="mt-12 sticky bottom-0 flex-1 flex flex-col justify-end lg:hidden">
                            <div class="py-4 bg-white">
                                <button class="relative ml-1 w-6 h-6 text-red-600 lg:hidden focus:outline-none focus:shadow-outline" aria-label="Menu" @click.prevent="navIsOpen = !navIsOpen">
                                    <svg x-show.transition.opacity="! navIsOpen" class="absolute inset-0 w-6 h-6" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    <svg x-show.transition.opacity="navIsOpen" x-cloak class="absolute inset-0 w-6 h-6" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="flex-1 pl-20 lg:pl-0">
                    <div class="max-w-screen-lg px-4 sm:px-16 lg:px-24">
                        <header class="flex flex-col items-end lg:mt-8 lg:flex-row-reverse">
                            <div class="mt-8 w-full lg:mt-0 lg:w-64 lg:pl-12">
                                <div>
                                    <label class="text-gray-600 text-xs tracking-widest uppercase" for="version-switch">Version</label>
                                    <div x-data class="relative w-full border-b border-gray-600 border-opacity-50 transition-all duration-500 focus-within:border-gray-600">
                                        <select
                                            id="version-switcher"
                                            aria-label="Laravel version"
                                            class="flex-1 w-full px-0 py-1 placeholder-gray-900 tracking-wide focus:outline-none"
                                            @change="window.location = $event.target.value"
                                        >
                                            @foreach ($versions as $key => $display)
                                                <option {{ $currentVersion == $key ? 'selected' : '' }} value="{{ url('docs/'.$key.$currentSection) }}">{{ $display }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div x-data="searchComponent()" x-init="init()" class="relative mt-8 flex justify-end w-full lg:mt-0">
                                <div
                                    class="relative w-full border-b border-gray-600 border-opacity-50 overflow-hidden transition-all duration-500 focus-within:border-gray-600"
                                    @click="searchIsOpen = true"
                                    @click.away="clear()"
                                    @keydown.window.escape="clear()"
                                >
                                    <svg class="absolute inset-y-0 left-0 z-10 mt-1 w-5 h-5 text-gray-900 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <input
                                        x-model.debouce.200ms="search"
                                        class="flex-1 w-full pl-8 pr-4 py-1 placeholder-gray-900 tracking-wide focus:outline-none"
                                        id="search-docs-input"
                                        placeholder="Search Docs"
                                        aria-label="Search in the documentation"
                                        @keydown.arrow-up.prevent="focusPreviousResult()"
                                        @keydown.arrow-down.prevent="focusNextResult()"
                                    >
                                </div>
                                @include('partials.search-results')
                            </div>
                        </header>

                        <section class="mt-8 md:mt-16">
                            <section class="docs_main max-w-prose">
                                @unless ($currentVersion == 'master' || version_compare($currentVersion, DEFAULT_VERSION) >= 0)
                                    <blockquote>
                                        <div class="mb-10 max-w-2xl mx-auto px-4 py-8 shadow-lg lg:flex lg:items-center">
                                            <div class="w-20 h-20 mb-6 flex items-center justify-center flex-shrink-0 bg-orange-600 lg:mb-0">
                                                <img src="{{ asset('/img/callouts/exclamation.min.svg') }}" alt="Icon" class="opacity-75" />
                                            </div>

                                            <p class="content mb-0">
                                                <strong>WARNING</strong> You're browsing the documentation for an old version of Laravel.
                                                Consider upgrading your project to <a href="{{ route('docs.version', DEFAULT_VERSION) }}">Laravel {{ DEFAULT_VERSION }}</a>.
                                            </p>
                                        </div>
                                    </blockquote>
                                @endunless

                                @if ($currentVersion == 'master' || version_compare($currentVersion, DEFAULT_VERSION) > 0)
                                    <blockquote>
                                        <div class="callout">
                                            <div class="icon orange">
                                                <img src="{{ asset('/img/callouts/exclamation.min.svg') }}" alt="Icon"/>
                                            </div>

                                            <p class="content">
                                                <strong>WARNING</strong> You're browsing the documentation for an upcoming version of Laravel.
                                                The documentation and features of this release are subject to change.
                                            </p>
                                        </div>
                                    </blockquote>
                                @endif

                                {!! $content !!}
                            </section>
                        </section>
                    </div>
                </section>
            </div>
        </div>

    </div>
@stop
