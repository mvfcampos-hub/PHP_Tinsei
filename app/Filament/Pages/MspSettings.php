<?php

namespace App\Filament\Pages;

use App\Models\MspSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class MspSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Produtos & Serviços';

    protected static ?string $navigationLabel = 'Configurações do MSP';

    protected static ?string $title = 'Configurações do MSP';

    protected static string $view = 'filament.pages.msp-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = MspSetting::current();

        $this->form->fill([
            'server_price' => $setting->server_price,
            'minimum_contract' => $setting->minimum_contract,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('server_price')
                    ->label('Preço do servidor (R$/mês, fixo por servidor)')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
                TextInput::make('minimum_contract')
                    ->label('Contrato mínimo (R$/mês)')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        MspSetting::current()->update($data);

        Notification::make()
            ->title('Configurações do MSP salvas com sucesso')
            ->success()
            ->send();
    }
}
