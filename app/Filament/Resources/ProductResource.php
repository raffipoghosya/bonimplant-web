<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedCube;
    }

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Translations')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('🇦🇲 Armenian (HY)')
                        ->schema([
                            Forms\Components\TextInput::make('title.hy')
                                ->label('Title (Armenian)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) =>
                                    $set('slug', Str::slug($state))
                                ),
                            Forms\Components\RichEditor::make('description.hy')
                                ->label('Description (Armenian)')
                                ->columnSpanFull(),
                        ]),
                    Tab::make('🇷🇺 Russian (RU)')
                        ->schema([
                            Forms\Components\TextInput::make('title.ru')
                                ->label('Title (Russian)'),
                            Forms\Components\RichEditor::make('description.ru')
                                ->label('Description (Russian)')
                                ->columnSpanFull(),
                        ]),
                    Tab::make('🇬🇧 English (EN)')
                        ->schema([
                            Forms\Components\TextInput::make('title.en')
                                ->label('Title (English)'),
                            Forms\Components\RichEditor::make('description.en')
                                ->label('Description (English)')
                                ->columnSpanFull(),
                        ]),
                ]),

            Section::make('Details')
                ->schema([
                    Forms\Components\Select::make('bodyParts')
                        ->label('Body Parts')
                        ->relationship('bodyParts', 'name')
                        ->multiple()
                        ->options(fn () => BodyPart::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get()
                            ->mapWithKeys(fn ($bp) => [$bp->id => $bp->getTranslation('name', app()->getLocale()) ?: $bp->getTranslation('name', 'en')])
                            ->toArray()
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->columnSpanFull(),
                ]),

            Section::make('Settings')
                ->columns(2)
                ->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(fn () => Category::all()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured')
                        ->default(false),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Sort Order')
                        ->numeric()
                        ->default(0),
                ]),

            Section::make('Primary Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('primary_image')
                        ->label('Primary Image')
                        ->collection('primary_image')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1',
                            '4:3',
                            '16:9',
                            null,
                        ])
                        ->maxSize(5120)
                        ->columnSpanFull(),
                ]),

            Section::make('Gallery Images')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->label('Gallery')
                        ->collection('gallery')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->maxSize(5120)
                        ->reorderable()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('primary_image')
                    ->collection('primary_image')
                    ->conversion('thumb')
                    ->label('Image')
                    ->circular(false)
                    ->width(60)
                    ->height(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('title', app()->getLocale(), false) ?: $record->getTranslation('title', 'en', false) ?: '—')
                    ->searchable(query: fn ($query, $search) => $query->whereRaw("JSON_EXTRACT(title, '$.hy') LIKE ?", ["%{$search}%"])
                        ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$search}%"]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->formatStateUsing(fn ($record) => $record->category?->getTranslation('name', 'en') ?? '—'),
                Tables\Columns\TextColumn::make('bodyParts.name')
                    ->label('Body Parts')
                    ->formatStateUsing(fn ($record) => $record->bodyParts->map(fn ($bp) => $bp->getTranslation('name', 'en'))->join(', ') ?: '—'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(fn () => Category::all()->pluck('name', 'id')),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
