<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\EventItem;
use App\Models\News;
use App\Models\StateClientCount;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $clients = StateClientCount::active()->sum('client_count');
        $states = StateClientCount::active()->where('client_count', '>', 0)->where('code', '!=', StateClientCount::ABROAD)->count();

        return [
            Stat::make('Clientes no mapa', br_number($clients))
                ->description("{$states} estados com clientes")
                ->icon('heroicon-o-map')
                ->color('primary'),
            Stat::make('Mensagens novas', ContactMessage::where('status', 'novo')->count())
                ->description(ContactMessage::where('created_at', '>=', now()->subDays(30))->count().' nos últimos 30 dias')
                ->icon('heroicon-o-inbox')
                ->color('warning'),
            Stat::make('Notícias publicadas', News::published()->count())
                ->description('Última: '.(News::published()->latest('published_at')->value('published_at')?->format('d/m/Y') ?? '—'))
                ->icon('heroicon-o-newspaper'),
            Stat::make('Próximos eventos', EventItem::upcoming()->count())
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
