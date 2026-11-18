<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mensagens enviadas pelo formulário "Fale conosco" do site.
class ContactMessage extends Model
{
    public const SUBJECTS = [
        'contato' => 'Contato geral',
        'comercial' => 'Comercial / orçamento',
        'revenda' => 'Quero ser revenda',
        'suporte' => 'Pós-venda / suporte técnico',
        'imprensa' => 'Imprensa',
        'fornecedor' => 'Sou fornecedor',
    ];

    public const STATUSES = [
        'novo' => 'Novo',
        'em_atendimento' => 'Em atendimento',
        'respondido' => 'Respondido',
        'arquivado' => 'Arquivado',
    ];

    protected $fillable = [
        'subject_type', 'name', 'company', 'email', 'phone', 'city', 'state', 'message',
        'status', 'internal_notes', 'ip_address',
    ];
}
