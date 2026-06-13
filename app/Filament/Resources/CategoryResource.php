<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedTag;
    }

    protected static ?string $navigationLabel = 'Categories';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Translations')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('🇦🇲 Armenian (HY)')
                        ->schema([
                            Forms\Components\TextInput::make('name.hy')
                                ->label('Name (Armenian)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        ]),
                    Tab::make('🇷🇺 Russian (RU)')
                        ->schema([Forms\Components\TextInput::make('name.ru')->label('Name (Russian)')]),
                    Tab::make('🇬🇧 English (EN)')
                        ->schema([Forms\Components\TextInput::make('name.en')->label('Name (English)')]),
                ]),

            Section::make('Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('type')
                        ->options([
                            'orthopedics'  => 'Orthopedics',
                            'traumatology' => 'Traumatology',
                            'instruments'  => 'Instruments',
                        ])
                        ->required()
                        ->default('orthopedics'),
                    Forms\Components\Select::make('parent_id')
                        ->label('Parent Category')
                        ->options(fn () => Category::whereNull('parent_id')->pluck('name', 'id'))
                        ->nullable()
                        ->searchable(),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Textarea::make('icon_svg')
                        ->label('Icon SVG (paste inline SVG code)')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('name', 'en') ?: $record->getTranslation('name', 'hy')),
                Tables\Columns\TextColumn::make('type')->badge()
                    ->colors(['primary' => 'orthopedics', 'warning' => 'traumatology', 'success' => 'instruments']),
                Tables\Columns\TextColumn::make('parent.name')
                    ->formatStateUsing(fn ($record) => $record->parent?->getTranslation('name', 'en') ?? '—')
                    ->label('Parent'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('products_count')->counts('products')->label('Products'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
