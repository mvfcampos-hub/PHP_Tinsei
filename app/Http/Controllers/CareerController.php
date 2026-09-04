<?php

namespace App\Http\Controllers;

use App\Mail\CareerApplicationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class CareerController extends Controller
{
    public const AREAS = [
        'comercial' => 'Comercial e Vendas',
        'suporte' => 'Suporte Técnico',
        'desenvolvimento' => 'Desenvolvimento de Software',
        'implantacao' => 'Implantação e Consultoria',
        'administrativo' => 'Administrativo e Financeiro',
        'outra' => 'Outra área / Cadastro geral',
    ];

    public function index()
    {
        return view('careers.index', ['areas' => self::AREAS]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'area' => ['required', 'string', 'in:'.implode(',', array_keys(self::AREAS))],
            'linkedin' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:3000'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $resumePath = null;
        $resumeName = null;

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->getRealPath();
            $resumeName = $request->file('resume')->getClientOriginalName();
        }

        try {
            Mail::to('rh@databit.com.br')->send(new CareerApplicationMail([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'area' => self::AREAS[$data['area']],
                'linkedin' => $data['linkedin'] ?? null,
                'message' => $data['message'],
                'resume_name' => $resumeName,
            ], $resumePath));
        } catch (Throwable $e) {
            Log::error('Falha ao enviar e-mail de candidatura (Trabalhe Conosco): '.$e->getMessage(), ['exception' => $e]);

            return redirect()->route('careers.index')
                ->withInput()
                ->with('career_error', true);
        }

        return redirect()->route('careers.index')->with('career_success', true);
    }
}
