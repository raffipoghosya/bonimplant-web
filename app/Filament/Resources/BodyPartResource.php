<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BodyPartResource\Pages;
use App\Models\BodyPart;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BodyPartResource extends Resource
{
    protected static ?string $model = BodyPart::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedUser;
    }

    protected static ?string $navigationLabel = 'Body Parts';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Tabs::make('Translations')
                ->columnSpanFull()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🇦🇲 Armenian (HY)')
                        ->schema([
                            Forms\Components\TextInput::make('name.hy')
                                ->label('Name (Armenian)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇷🇺 Russian (RU)')
                        ->schema([Forms\Components\TextInput::make('name.ru')->label('Name (Russian)')]),
                    Forms\Components\Tabs\Tab::make('🇬🇧 English (EN)')
                        ->schema([Forms\Components\TextInput::make('name.en')->label('Name (English)')]),
                ]),

            Forms\Components\Section::make('Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('skeleton_zone')
                        ->options([
                            'head'         => 'Head / Neck',
                            'torso'        => 'Torso / Spine',
                            'upper_limbs'  => 'Upper Limbs (Arms)',
                            'lower_limbs'  => 'Lower Limbs (Legs)',
                        ])
                        ->required()
                        ->default('torso'),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('name', 'en') ?: $record->getTranslation('name', 'hy')),
                Tables\Columns\TextColumn::make('skeleton_zone')->badge(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('products_count')->counts('products')->label('Products'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBodyParts::route('/'),
            'create' => Pages\CreateBodyPart::route('/create'),
            'edit' => Pages\EditBodyPart::route('/{record}/edit'),
        ];
    }
}
