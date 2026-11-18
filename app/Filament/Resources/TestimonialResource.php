<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\StateClientCount;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Institucional';

    protected static ?string $navigationLabel = 'Depoimentos';

    protected static ?string $modelLabel = 'depoimento';

    protected static ?string $pluralModelLabel = 'depoimentos';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')->label('Nome')->required(),
                Forms\Components\TextInput::make('role')->label('Cargo'),
                Forms\Components\TextInput::make('company')->label('Empresa (revenda / cliente)'),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('city')->label('Cidade')->columnSpan(2),
                    Forms\Components\Select::make('state')->label('UF')->options(StateClientCount::STATES)->searchable(),
                ]),
                Forms\Components\Textarea::make('quote')->label('Depoimento')->required()->rows(5)->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')->label('Foto ou logo')->image()->directory('testimonials')->imageEditor()->circleCropper(),
                Forms\Components\TextInput::make('video_url')->label('Vídeo-depoimento (YouTube, opcional)')->url(),
                Forms\Components\Select::make('rating')->label('Avaliação')
                    ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'])
                    ->default(5)->native(false)->required(),
                Forms\Components\TextInput::make('sort_order')->label('Ordem')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->label('Destaque (aparece primeiro)'),
                Forms\Components\Toggle::make('is_active')->label('Publicado')->default(true)
                    ->helperText('Publique somente depoimentos reais e autorizados pelo cliente.'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label('')->circular(),
                Tables\Columns\TextColumn::make('client_name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('company')->label('Empresa')->searchable(),
                Tables\Columns\TextColumn::make('state')->label('UF'),
                Tables\Columns\TextColumn::make('quote')->label('Depoimento')->limit(60)->toggleable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destaque')->boolean(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Publicado'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Publicado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
