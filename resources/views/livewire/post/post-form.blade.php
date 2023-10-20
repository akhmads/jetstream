<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form wire:submit.prevent="store">

                <div class="mb-4">
                    <x-label for="title" :value="__('Title')" class="mb-1" />
                    <x-input id="title" wire:model="title" class="w-full" autofocus autocomplete="title" />
                    <x-input-error class="mt-2" for="title" />
                </div>

                <div wire:ignore class="md:grid md:grid-cols-12 md:gap-8 mb-8">
                    <div class="md:col-span-6 mb-4">
                        <x-label for="content" :value="__('Content')" class="mb-1" />
                        <x-hyco.textarea id="content" wire:model="content" class="w-full h-[400px]"></x-hyco.textarea>
                        <x-input-error class="mt-2" for="content" />
                    </div>
                    <div class="md:col-span-6 mb-4">
                        <x-label :value="__('Preview')" class="mb-1" />
                        <div class="prose prose-md">
                            {!! $contentPreview ?? '' !!}
                        </div>
                    </div>
                </div>

                {{-- <div id="editor" style="height:100px;"></div> --}}

                <div class="flex justify-center gap-4">
                    <x-hyco.link href="{{ route('post') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </div>

            </form>
        </div>
    </div>
</div>

<script type="module">
    import hljs from 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/es/highlight.min.js';
    document.addEventListener('DOMContentLoaded', function () {
        hljs.highlightAll();
    });

    document.addEventListener('livewire:navigating', () => {
        hljs.highlightAll();
    });

    document.addEventListener('livewire:initialized', () => {

        hljs.highlightAll();

        var simplemde = new SimpleMDE({
            element: document.getElementById("content"),
            placeholder: "Let's write something cool's",
            indentWithTabs: true,
            spellChecker: false,
            renderingConfig: {
                singleLineBreaks: false,
                codeSyntaxHighlighting: true,
            }
        });

        simplemde.codemirror.on("change", function(){
            @this.set('content',simplemde.value());
            hljs.highlightAll();
        });
    });
</script>
