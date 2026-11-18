@extends('layouts.app')

@section('title', 'Depoimentos')
@section('description', 'O que revendas e clientes de todo o Brasil dizem sobre a Tinsei.')

@section('content')
<x-page-hero eyebrow="Depoimentos" title="Quem revende Tinsei, recomenda"
    subtitle="Revendas, locadoras e empresas de outsourcing de impressão contam como é trabalhar com a Tinsei." />

<section class="bg-slate-50 py-20">
    <div class="container-site">
        @if ($testimonials->isNotEmpty())
            <div class="columns-1 gap-6 space-y-6 md:columns-2 lg:columns-3">
                @foreach ($testimonials as $testimonial)
                    <div class="break-inside-avoid"><x-testimonial-card :testimonial="$testimonial" /></div>
                @endforeach
            </div>
        @endif

        <div class="mt-12 rounded-3xl bg-brand-900 p-8 text-center sm:p-12">
            <x-ico name="quote" class="mx-auto h-10 w-10 text-gold-400" />
            <h2 class="mt-4 text-2xl font-bold text-white">É cliente Tinsei? Conte sua experiência.</h2>
            <p class="mx-auto mt-2 max-w-xl text-brand-100/80">Seu depoimento ajuda outras revendas a conhecerem a Tinsei. Publicamos somente com a sua autorização.</p>
            <a href="{{ route('contact.index', ['assunto' => 'contato']) }}" class="btn-gold mt-6">Enviar meu depoimento</a>
        </div>
    </div>
</section>
@endsection
