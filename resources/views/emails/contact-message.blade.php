<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Nova mensagem pelo site</title></head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <h2 style="color: #003B5A;">Nova mensagem pelo site da Tinsei</h2>
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 560px;">
        <tr><td style="font-weight: bold; width: 140px;">Assunto</td><td>{{ \App\Models\ContactMessage::SUBJECTS[$contact->subject_type] ?? $contact->subject_type }}</td></tr>
        <tr><td style="font-weight: bold;">Nome</td><td>{{ $contact->name }}</td></tr>
        @if ($contact->company)<tr><td style="font-weight: bold;">Empresa</td><td>{{ $contact->company }}</td></tr>@endif
        <tr><td style="font-weight: bold;">E-mail</td><td>{{ $contact->email }}</td></tr>
        @if ($contact->phone)<tr><td style="font-weight: bold;">Telefone</td><td>{{ $contact->phone }}</td></tr>@endif
        @if ($contact->city || $contact->state)<tr><td style="font-weight: bold;">Cidade/UF</td><td>{{ trim($contact->city.' / '.$contact->state, ' /') }}</td></tr>@endif
    </table>
    <p style="font-weight: bold; margin-top: 16px;">Mensagem</p>
    <p style="white-space: pre-line;">{{ $contact->message }}</p>
    <p style="margin-top: 16px; color: #64748b; font-size: 13px;">A mensagem também está salva no painel, em Comercial › Mensagens do site.</p>
</body>
</html>
