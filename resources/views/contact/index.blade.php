@extends('layouts.app')

@section('title', 'Contato')
@section('description', 'Fale com a Tinsei: telefone, WhatsApp, e-mail e endereço em Belo Horizonte/MG. Atendimento a revendas de todo o Brasil.')

@section('content')
<x-page-hero eyebrow="Fale conosco" title="Contato"
    subtitle="Acelere seu negócio de maneira econômica e sustentável. Nossa equipe responde rapidamente pelo canal que for melhor para você." />

<section class="bg-slate-50 py-16 sm:py-20">
    <div class="container-site grid gap-8 lg:grid-cols-3">
        <aside class="space-y-4">
            <a href="{{ whatsapp_url('Olá! Vim pelo site da Tinsei.') }}" target="_blank" rel="noopener" class="card flex items-center gap-4 p-5 transition hover:border-[#25D366] hover:shadow-soft">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#25D366]/10 text-[#128C7E]"><x-ico name="phone" class="h-6 w-6" /></span>
                <div><p class="text-xs text-slate-500">WhatsApp</p><p class="font-semibold text-brand-900">{{ setting('phone') }}</p></div>
            </a>
            <a href="mailto:{{ setting('email') }}" class="card flex items-center gap-4 p-5 transition hover:border-brand-300 hover:shadow-soft">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700"><x-ico name="mail" class="h-6 w-6" /></span>
                <div class="min-w-0"><p class="text-xs text-slate-500">E-mail</p><p class="truncate font-semibold text-brand-900">{{ setting('email') }}</p></div>
            </a>
            <div class="card flex gap-4 p-5">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700"><x-ico name="pin" class="h-6 w-6" /></span>
                <div><p class="text-xs text-slate-500">Endereço</p><p class="whitespace-pre-line text-sm font-medium text-brand-900">{{ setting('address') }}</p>
                @if (setting('business_hours'))<p class="mt-2 text-xs text-slate-500">{{ setting('business_hours') }}</p>@endif</div>
            </div>
            <a href="{{ setting('store_reseller_url') }}" target="_blank" rel="noopener" class="block rounded-2xl bg-brand-900 p-5 text-white transition hover:bg-brand-800">
                <p class="font-semibold">Quer ser uma revenda?</p>
                <p class="mt-1 text-sm text-brand-200">Faça o cadastro direto na loja e acesse preços exclusivos →</p>
            </a>
        </aside>

        <div class="card p-6 sm:p-10 lg:col-span-2">
            @if (session('contact_success'))
                <div class="mb-6 flex gap-3 rounded-xl border border-leaf-300 bg-leaf-50 p-4 text-sm text-leaf-800" role="status">
                    <x-ico name="check" class="h-5 w-5 shrink-0" />
                    <p><strong>Mensagem enviada!</strong> Obrigado pelo contato — nossa equipe retornará em breve.</p>
                </div>
            @endif

            <h2 class="text-2xl font-bold text-brand-900">Envie uma mensagem</h2>
            <p class="mt-1 text-sm text-slate-500">Campos com * são obrigatórios.</p>

            <form action="{{ route('contact.store') }}" method="POST" class="mt-8 grid gap-5 sm:grid-cols-2">
                @csrf
                <div class="hidden" aria-hidden="true"><label>Não preencha <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

                <div class="sm:col-span-2">
                    <label for="subject_type" class="form-label">Assunto *</label>
                    <select id="subject_type" name="subject_type" class="form-input" required>
                        @foreach ($subjects as $value => $label)
                            <option value="{{ $value }}" @selected(old('subject_type', $selectedSubject) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="name" class="form-label">Nome *</label>
                    <input id="name" name="name" value="{{ old('name') }}" required maxlength="150" class="form-input" autocomplete="name">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="company" class="form-label">Empresa</label>
                    <input id="company" name="company" value="{{ old('company') }}" maxlength="150" class="form-input" autocomplete="organization">
                </div>
                <div>
                    <label for="email" class="form-label">E-mail *</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="150" class="form-input" autocomplete="email">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="form-label">Telefone / WhatsApp</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" maxlength="30" class="form-input" autocomplete="tel">
                </div>
                <div>
                    <label for="city" class="form-label">Cidade</label>
                    <input id="city" name="city" value="{{ old('city') }}" maxlength="100" class="form-input" autocomplete="address-level2">
                </div>
                <div>
                    <label for="state" class="form-label">UF</label>
                    <select id="state" name="state" class="form-input">
                        <option value="">Selecione</option>
                        @foreach ($states as $code => $name)
                            <option value="{{ $code }}" @selected(old('state') === $code)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="form-label">Mensagem *</label>
                    <textarea id="message" name="message" rows="5" required maxlength="5000" class="form-input">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-start gap-3 text-sm text-slate-600">
                        <input type="checkbox" name="consent" value="1" @checked(old('consent')) required class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500">
                        <span>Concordo com o uso dos meus dados para que a Tinsei retorne este contato, conforme a <a href="{{ route('pages.show', 'politica-de-privacidade') }}" class="font-semibold text-brand-700 hover:underline">Política de Privacidade</a>.</span>
                    </label>
                    @error('consent')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="btn-primary w-full sm:w-auto !px-8">Enviar mensagem <x-ico name="arrow-right" class="h-4 w-4" /></button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="h-[380px] bg-slate-200">
    <iframe title="Mapa: sede da Tinsei" class="h-full w-full border-0 grayscale-[30%]" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps?q={{ urlencode(setting('maps_query')) }}&output=embed"></iframe>
</section>
@endsection
