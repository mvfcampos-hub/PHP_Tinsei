<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\StateClientCount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return view('contact.index', [
            'subjects' => ContactMessage::SUBJECTS,
            'states' => StateClientCount::STATES,
            'selectedSubject' => array_key_exists($request->query('assunto'), ContactMessage::SUBJECTS) ? $request->query('assunto') : 'contato',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Campo-isca contra robôs: humanos não veem nem preenchem.
        if (filled($request->input('website'))) {
            return redirect()->route('contact.index')->with('contact_success', true);
        }

        $data = $request->validate([
            'subject_type' => ['required', 'in:'.implode(',', array_keys(ContactMessage::SUBJECTS))],
            'name' => ['required', 'string', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'in:'.implode(',', array_keys(StateClientCount::STATES))],
            'message' => ['required', 'string', 'max:5000'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'É preciso concordar com o uso dos dados para retornarmos o contato.',
        ]);

        unset($data['consent']);

        $message = ContactMessage::create($data + ['ip_address' => $request->ip()]);

        // A mensagem fica salva no painel mesmo que o envio do e-mail falhe.
        try {
            if ($to = setting('contact_notify_email')) {
                Mail::to($to)->send(new ContactMessageMail($message));
            }
        } catch (Throwable $e) {
            Log::warning('Falha ao enviar aviso de mensagem do site: '.$e->getMessage());
        }

        return redirect()->route('contact.index')->with('contact_success', true);
    }
}
