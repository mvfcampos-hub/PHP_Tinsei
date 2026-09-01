<?php

namespace App\Filament\Resources\EventItemResource\Pages;

use App\Filament\Resources\EventItemResource;
use App\Services\CfnCalendarSync;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListEventItems extends ListRecords
{
    protected static string $resource = EventItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sync_cfn')
                ->label('Importar do Calendário CFN')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalDescription('Isso busca os eventos publicados em calendario.cfn.org.br e cria ou atualiza os eventos correspondentes aqui. Eventos cadastrados manualmente não são afetados.')
                ->action(function () {
                    try {
                        $result = app(CfnCalendarSync::class)->sync();

                        Notification::make()
                            ->title('Importação concluída')
                            ->body("{$result['created']} evento(s) novo(s), {$result['updated']} atualizado(s).")
                            ->success()
                            ->send();
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Falha ao importar')
                            ->body('Não foi possível acessar o calendário do CFN no momento. Tente novamente mais tarde.')
                            ->danger()
                            ->send();
                    }
                }),
            Actions\CreateAction::make(),
        ];
    }
}
