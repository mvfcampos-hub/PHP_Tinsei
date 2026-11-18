<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationLabel = 'Configurações do site';

    protected static ?string $title = 'Configurações do site';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(array_merge(SiteSetting::DEFAULTS, (array) SiteSetting::current()->data));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tabs\Tab::make('Empresa')->icon('heroicon-o-building-office')->schema([
                        TextInput::make('company_name')->label('Nome fantasia')->required(),
                        TextInput::make('legal_name')->label('Razão social'),
                        TextInput::make('cnpj')->label('CNPJ'),
                        TextInput::make('tagline')->label('Slogan')->columnSpanFull(),
                        Textarea::make('address')->label('Endereço')->rows(3),
                        TextInput::make('maps_query')->label('Endereço para o mapa (Google Maps)'),
                        TextInput::make('business_hours')->label('Horário de atendimento'),
                    ])->columns(2),
                    Tabs\Tab::make('Contatos')->icon('heroicon-o-phone')->schema([
                        TextInput::make('phone')->label('Telefone'),
                        TextInput::make('whatsapp')->label('WhatsApp (atendimento)')->helperText('Somente números, com DDI: 553133961435'),
                        TextInput::make('whatsapp_sales')->label('WhatsApp (comercial / loja)'),
                        TextInput::make('email')->label('E-mail de atendimento')->email(),
                        TextInput::make('contact_notify_email')->label('Avisar mensagens do site para')->email(),
                        TextInput::make('careers_email')->label('Receber currículos em')->email(),
                    ])->columns(2),
                    Tabs\Tab::make('Loja e redes')->icon('heroicon-o-shopping-bag')->schema([
                        TextInput::make('store_url')->label('Loja / portfólio de produtos')->url()->required(),
                        TextInput::make('store_reseller_url')->label('Cadastro de revenda (loja)')->url(),
                        TextInput::make('instagram_url')->label('Instagram')->url(),
                        TextInput::make('youtube_url')->label('YouTube')->url(),
                        TextInput::make('linkedin_url')->label('LinkedIn')->url(),
                        TextInput::make('facebook_url')->label('Facebook')->url(),
                        TextInput::make('institutional_video_url')->label('Vídeo institucional (YouTube)')->url(),
                    ])->columns(2),
                    Tabs\Tab::make('Números')->icon('heroicon-o-chart-bar')->schema([
                        Section::make()->description('Números exibidos na home e na página Sobre.')->schema([
                            TextInput::make('active_clients_override')->label('Clientes ativos')
                                ->helperText('Vazio = soma automática do Mapa de Clientes.'),
                            TextInput::make('portfolio_items')->label('Itens no portfólio')->placeholder('1.800+'),
                            TextInput::make('ewaste_kg')->label('Lixo eletrônico recuperado (kg)')->placeholder('1.800.000'),
                            TextInput::make('founded_year')->label('Ano de fundação')->numeric(),
                        ])->columns(2),
                    ]),
                    Tabs\Tab::make('Integrações')->icon('heroicon-o-puzzle-piece')->schema([
                        TextInput::make('google_analytics_id')->label('Google Analytics (ID G-XXXX)'),
                    ]),
                ])->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update(['data' => $this->form->getState()]);

        Notification::make()->title('Configurações salvas')->success()->send();
    }
}
