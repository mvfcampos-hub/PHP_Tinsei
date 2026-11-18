<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Comercial';

    protected static ?string $navigationLabel = 'Mensagens do site';

    protected static ?string $modelLabel = 'mensagem';

    protected static ?string $pluralModelLabel = 'mensagens';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::where('status', 'novo')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')->label('Status')->options(ContactMessage::STATUSES)->native(false)->required(),
                Forms\Components\Textarea::make('internal_notes')->label('Anotações internas')->rows(4)->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()->schema([
                    Infolists\Components\TextEntry::make('subject_type')->label('Assunto')
                        ->formatStateUsing(fn ($state) => ContactMessage::SUBJECTS[$state] ?? $state)->badge(),
                    Infolists\Components\TextEntry::make('status')->label('Status')
                        ->formatStateUsing(fn ($state) => ContactMessage::STATUSES[$state] ?? $state)->badge(),
                    Infolists\Components\TextEntry::make('created_at')->label('Recebida em')->dateTime('d/m/Y H:i'),
                    Infolists\Components\TextEntry::make('name')->label('Nome'),
                    Infolists\Components\TextEntry::make('company')->label('Empresa')->placeholder('—'),
                    Infolists\Components\TextEntry::make('email')->label('E-mail')->copyable()
                        ->url(fn ($record) => 'mailto:'.$record->email),
                    Infolists\Components\TextEntry::make('phone')->label('Telefone')->placeholder('—')->copyable(),
                    Infolists\Components\TextEntry::make('city')->label('Cidade/UF')
                        ->getStateUsing(fn ($record) => trim($record->city.' / '.$record->state, ' /') ?: '—'),
                    Infolists\Components\TextEntry::make('message')->label('Mensagem')->columnSpanFull()->prose(),
                    Infolists\Components\TextEntry::make('internal_notes')->label('Anotações internas')->columnSpanFull()->placeholder('—'),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Recebida')->dateTime('d/m/Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('subject_type')->label('Assunto')->badge()
                    ->formatStateUsing(fn ($state) => ContactMessage::SUBJECTS[$state] ?? $state),
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('company')->label('Empresa')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->searchable(),
                Tables\Columns\TextColumn::make('state')->label('UF'),
                Tables\Columns\SelectColumn::make('status')->label('Status')->options(ContactMessage::STATUSES),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Status')->options(ContactMessage::STATUSES),
                Tables\Filters\SelectFilter::make('subject_type')->label('Assunto')->options(ContactMessage::SUBJECTS),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Atender'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
