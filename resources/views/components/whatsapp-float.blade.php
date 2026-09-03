@props(['number' => '553134168225', 'message' => 'Olá! Vim pelo site da Databit e gostaria de mais informações.'])

<a
    href="https://wa.me/{{ $number }}?text={{ urlencode($message) }}"
    target="_blank"
    rel="noopener"
    aria-label="Fale com a Databit pelo WhatsApp"
    onclick="window.trackEvent && window.trackEvent('whatsapp_click', { page_path: window.location.pathname })"
    class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-50 flex h-14 w-14 items-center justify-center"
>
    <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-75 animate-ping"></span>
    <span class="relative flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-black/20 transition hover:scale-105 hover:shadow-xl">
        <span class="sr-only">Fale conosco pelo WhatsApp</span>
        <svg class="h-7 w-7" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path d="M16.004 2.667c-7.363 0-13.333 5.97-13.333 13.333 0 2.353.615 4.647 1.784 6.667L2.667 29.333l6.822-1.789a13.27 13.27 0 006.515 1.72h.006c7.362 0 13.332-5.97 13.332-13.333 0-3.56-1.387-6.907-3.906-9.427a13.246 13.246 0 00-9.432-3.907zm0 24.4h-.005a11.06 11.06 0 01-5.636-1.542l-.404-.24-4.05 1.062 1.082-3.948-.264-.406a11.037 11.037 0 01-1.692-5.893c0-6.107 4.968-11.075 11.074-11.075a11 11 0 017.831 3.246 10.995 10.995 0 013.242 7.833c0 6.106-4.968 11.074-11.074 11.074l-.104-.111zm6.07-8.29c-.333-.167-1.966-.97-2.271-1.081-.305-.111-.527-.167-.75.167s-.86 1.08-1.054 1.303c-.194.222-.388.25-.72.083-.334-.166-1.41-.52-2.685-1.657-.992-.885-1.663-1.978-1.858-2.312-.194-.333-.021-.514.146-.68.15-.15.334-.389.5-.583.167-.194.222-.333.334-.556.111-.222.055-.417-.028-.583-.083-.167-.75-1.807-1.028-2.474-.27-.65-.545-.562-.75-.572-.194-.008-.417-.01-.639-.01-.222 0-.583.083-.888.417-.305.333-1.163 1.137-1.163 2.773 0 1.636 1.19 3.217 1.356 3.439.166.222 2.343 3.578 5.677 5.016.793.343 1.412.547 1.894.7.796.253 1.52.217 2.093.132.638-.096 1.966-.804 2.243-1.581.278-.777.278-1.443.194-1.581-.083-.139-.305-.222-.639-.389z"/>
        </svg>
    </span>
</a>
