<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Nova candidatura — Trabalhe Conosco</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <h2 style="color: #1447e6;">Nova candidatura recebida pelo site</h2>
    <p>Uma nova candidatura foi enviada pelo formulário "Trabalhe Conosco" do site da Databit.</p>
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 560px;">
        <tr><td style="font-weight: bold; width: 160px;">Nome</td><td>{{ $application['name'] }}</td></tr>
        <tr><td style="font-weight: bold;">E-mail</td><td>{{ $application['email'] }}</td></tr>
        <tr><td style="font-weight: bold;">Telefone</td><td>{{ $application['phone'] }}</td></tr>
        <tr><td style="font-weight: bold;">Área de interesse</td><td>{{ $application['area'] }}</td></tr>
        @if (!empty($application['linkedin']))
            <tr><td style="font-weight: bold;">LinkedIn</td><td>{{ $application['linkedin'] }}</td></tr>
        @endif
    </table>
    <p style="font-weight: bold; margin-top: 16px;">Mensagem</p>
    <p style="white-space: pre-line;">{{ $application['message'] }}</p>
    @if ($resumePath)
        <p style="margin-top: 16px; color: #64748b; font-size: 13px;">O currículo em anexo foi enviado junto com esta candidatura.</p>
    @endif
</body>
</html>
