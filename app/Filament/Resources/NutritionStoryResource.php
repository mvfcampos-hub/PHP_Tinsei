<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NutritionStoryResource\Pages;
use App\Models\NutritionStory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NutritionStoryResource extends Resource
{
    protected static ?string $model = NutritionStory::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Nutrição em Minas';

    protected static ?string $navigationLabel = 'Histórias';

    protected static ?string $modelLabel = 'história';

    protected static ?string $pluralModelLabel = 'histórias';

    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::where('status', 'pending')->count();

        return $pending > 0 ? (string) $pending : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título (nome do(a) profissional ou do projeto)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Forms\Components\Select::make('area')
                    ->label('Área de atuação')
                    ->options(array_combine(NutritionStory::AREAS, NutritionStory::AREAS))
                    ->required(),
                Forms\Components\TextInput::make('region')
                    ->label('Cidade / Região')
                    ->required(),
                Forms\Components\TextInput::make('role')
                    ->label('Cargo / Função')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('summary')
                    ->label('Resumo curto (aparece nos cards)')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('body')
                    ->label('História completa')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagem de capa')
                    ->image()
                    ->directory('nutricao-em-minas')
                    ->imageEditor()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Indicação (se enviada pelo site)')
                    ->schema([
                        Forms\Components\TextInput::make('submitter_name')
                            ->label('Nome de quem indicou')
                            ->disabled(),
                        Forms\Components\TextInput::make('submitter_email')
                            ->label('E-mail de quem indicou')
                            ->disabled(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => filled($record?->submitter_name)),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Aguardando revisão',
                        'published' => 'Publicada',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo (visível no site)')
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Destaque'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publicado em')
                    ->native(false)
                    ->default(now()),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('area')
                    ->label('Área')
                    ->badge(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Região')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'pending' ? 'Aguardando revisão' : 'Publicada')
                    ->color(fn (string $state) => $state === 'pending' ? 'warning' : 'success'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('area')
                    ->label('Área')
                    ->options(array_combine(NutritionStory::AREAS, NutritionStory::AREAS)),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Aguardando revisão',
                        'published' => 'Publicada',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNutritionStories::route('/'),
            'create' => Pages\CreateNutritionStory::route('/create'),
            'edit' => Pages\EditNutritionStory::route('/{record}/edit'),
        ];
    }
}
