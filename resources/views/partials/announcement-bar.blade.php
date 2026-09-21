@if ($announcement)
    @php
        $styles = match ($announcement->type) {
            'warning' => 'bg-brand-orange text-white',
            'urgent' => 'bg-red-600 text-white',
            default => 'bg-brand-blue text-brand-950',
        };
        $dismissKey = $announcement->dismissKey();
        $dismissible = $announcement->dismissible ? 'true' : 'false';
    @endphp
    <div
        x-data="{
            show: true,
            init() {
                if ({{ $dismissible }}) {
                    try {
                        this.show = localStorage.getItem('crn9_announcement_dismissed') !== '{{ $dismissKey }}';
                    } catch (e) {}
                }
            },
            dismiss() {
                this.show = false;
                try { localStorage.setItem('crn9_announcement_dismissed', '{{ $dismissKey }}'); } catch (e) {}
            },
        }"
        x-show="show"
        x-cloak
        role="region"
        aria-label="Aviso do CRN-9"
        class="{{ $styles }}"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-2.5 flex items-center gap-3">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 9v4m0 4h.01" />
            </svg>
            <p class="flex-1 text-sm font-medium">
                {{ $announcement->message }}
                @if ($announcement->link_url && $announcement->link_label)
                    <a href="{{ $announcement->link_url }}" class="underline font-semibold hover:no-underline ml-1">{{ $announcement->link_label }}</a>
                @endif
            </p>
            @if ($announcement->dismissible)
                <button type="button" @click="dismiss()" aria-label="Fechar aviso" class="shrink-0 rounded-lg p-1 hover:bg-black/10 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
@endif
