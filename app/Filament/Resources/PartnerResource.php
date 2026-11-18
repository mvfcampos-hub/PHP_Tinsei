<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Institucional';

    protected static ?string $navigationLabel = 'Sócios';

    protected static ?string $modelLabel = 'sócio';

    protected static ?string $pluralModelLabel = 'sócios';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')->required(),
                    Forms\Components\TextInput::make('role')->label('Cargo')->placeholder('Fundador e Sócio-Administrador'),
                    Forms\Components\TextInput::make('since_label')->label('Na Tinsei desde')->placeholder('2011'),
                    Forms\Components\FileUpload::make('photo')->label('Foto')->image()->directory('partners')->imageEditor()
                        ->helperText('Foto vertical (retrato), de preferência com fundo neutro.'),
                    Forms\Components\Textarea::make('summary')->label('Resumo (cartão)')->rows(3)->columnSpanFull(),
                    Forms\Components\RichEditor::make('bio')->label('Biografia completa')->columnSpanFull(),
                    Forms\Components\Textarea::make('quote')->label('Frase / visão (opcional)')->rows(2)->columnSpanFull()
                        ->helperText('Use somente frases ditas ou aprovadas pelo próprio sócio.'),
                    Forms\Components\TagsInput::make('highlights')->label('Destaques da trajetória')->columnSpanFull()
                        ->placeholder('Ex.: MBA em Finanças — Ibmec'),
                    Forms\Components\TextInput::make('linkedin_url')->label('LinkedIn')->url(),
                    Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                    Forms\Components\TextInput::make('sort_order')->label('Ordem')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Exibir no site')->default(true),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label('')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('role')->label('Cargo'),
                Tables\Columns\TextColumn::make('since_label')->label('Desde'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Exibir'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
