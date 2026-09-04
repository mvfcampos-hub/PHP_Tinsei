@extends('layouts.app')

@section('title', 'Trabalhe Conosco')
@section('description', 'Faça parte do time Databit. Envie seu currículo e conte um pouco sobre você — nossa equipe de RH entra em contato quando surgir uma oportunidade compatível com o seu perfil.')
@section('canonical', route('careers.index'))

@section('content')
    <section class="bg-brand-950 bg-grid-pattern relative overflow-hidden">
        <x-brand-mark class="hidden lg:block absolute -right-8 -top-10 h-36 w-auto opacity-[0.08] pointer-events-none select-none" aria-hidden="true" />
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24 text-center relative">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 text-accent-300 px-3 py-1 text-xs font-semibold mb-5 tracking-wide uppercase">
                Trabalhe Conosco
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
                Vem construir o futuro da tecnologia <span class="text-accent-400">com a gente</span>
            </h1>
            <p class="text-brand-200 mt-5 max-w-2xl mx-auto text-lg">
                Somos um time apaixonado por resolver problemas reais de gestão com tecnologia. Se você quer crescer
                com a gente, deixe seus dados abaixo — nosso RH entra em contato quando surgir uma oportunidade
                compatível com o seu perfil.
            </p>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            @if (session('career_success'))
                <div class="rounded-2xl bg-green-50 border border-green-200 text-green-800 px-5 py-4 mb-8 flex items-start gap-3">
                    <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    <div>
                        <p class="font-semibold">Candidatura enviada com sucesso!</p>
                        <p class="text-sm mt-0.5">Obrigado pelo interesse. Nossa equipe de RH vai analisar o seu perfil e entrar em contato caso surja uma oportunidade compatível.</p>
                    </div>
                </div>
            @endif

            @if (session('career_error'))
                <div class="rounded-2xl bg-red-50 border border-red-200 text-red-800 px-5 py-4 mb-8 flex items-start gap-3">
                    <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                    <div>
                        <p class="font-semibold">Não foi possível enviar sua candidatura.</p>
                        <p class="text-sm mt-0.5">Ocorreu um erro ao enviar sua mensagem. Tente novamente em instantes ou entre em contato pelo WhatsApp / e-mail informados no rodapé do site.</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('careers.store') }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 space-y-5">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nome completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Telefone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="area" class="block text-sm font-semibold text-slate-700 mb-1.5">Área de interesse</label>
                    <select name="area" id="area" required
                            class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Selecione uma área</option>
                        @foreach ($areas as $value => $label)
                            <option value="{{ $value }}" @selected(old('area') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('area') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="linkedin" class="block text-sm font-semibold text-slate-700 mb-1.5">LinkedIn ou portfólio <span class="font-normal text-slate-400">(opcional)</span></label>
                    <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/seu-perfil"
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                    @error('linkedin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-slate-700 mb-1.5">Conte um pouco sobre você</label>
                    <textarea name="message" id="message" rows="5" required
                              class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                              placeholder="Experiência, formação e o que te motiva a fazer parte da Databit.">{{ old('message') }}</textarea>
                    @error('message') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="resume" class="block text-sm font-semibold text-slate-700 mb-1.5">Currículo <span class="font-normal text-slate-400">(PDF ou Word, opcional, até 5MB)</span></label>
                    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
                    @error('resume') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 transition">
                    Enviar candidatura
                </button>
                <p class="text-xs text-slate-400 text-center">
                    Seus dados serão usados exclusivamente para fins de recrutamento, conforme a nossa
                    <a href="{{ route('pages.show', 'politicas-de-privacidade') }}" class="underline hover:text-slate-600">Política de Privacidade</a>.
                </p>
            </form>
        </div>
    </section>
@endsection
