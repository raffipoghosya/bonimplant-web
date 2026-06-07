<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedInformationCircle;
    }

    protected static ?string $navigationLabel = 'About Us';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Site Settings';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Tabs::make('Translations')
                ->columnSpanFull()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🇦🇲 Armenian (HY)')
                        ->schema([
                            Forms\Components\TextInput::make('title.hy')
                                ->label('Section Label (Armenian)'),
                            Forms\Components\TextInput::make('subtitle.hy')
                                ->label('Main Subtitle (Armenian)'),
                            Forms\Components\RichEditor::make('description.hy')
                                ->label('Full Description (Armenian)')
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇷🇺 Russian (RU)')
                        ->schema([
                            Forms\Components\TextInput::make('title.ru')->label('Section Label (Russian)'),
                            Forms\Components\TextInput::make('subtitle.ru')->label('Main Subtitle (Russian)'),
                            Forms\Components\RichEditor::make('description.ru')->label('Full Description (Russian)')->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇬🇧 English (EN)')
                        ->schema([
                            Forms\Components\TextInput::make('title.en')->label('Section Label (English)'),
                            Forms\Components\TextInput::make('subtitle.en')->label('Main Subtitle (English)'),
                            Forms\Components\RichEditor::make('description.en')->label('Full Description (English)')->columnSpanFull(),
                        ]),
                ]),

            Forms\Components\Section::make('Statistics')
                ->columns(3)
                ->schema([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('stat1_value')->label('Stat 1 Value')->default('50+'),
                        Forms\Components\TextInput::make('stat1_label.hy')->label('Stat 1 Label (HY)'),
                        Forms\Components\TextInput::make('stat1_label.ru')->label('Stat 1 Label (RU)'),
                        Forms\Components\TextInput::make('stat1_label.en')->label('Stat 1 Label (EN)'),
                    ]),
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('stat2_value')->label('Stat 2 Value')->default('40+'),
                        Forms\Components\TextInput::make('stat2_label.hy')->label('Stat 2 Label (HY)'),
                        Forms\Components\TextInput::make('stat2_label.ru')->label('Stat 2 Label (RU)'),
                        Forms\Components\TextInput::make('stat2_label.en')->label('Stat 2 Label (EN)'),
                    ]),
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('stat3_value')->label('Stat 3 Value')->default('250+'),
                        Forms\Components\TextInput::make('stat3_label.hy')->label('Stat 3 Label (HY)'),
                        Forms\Components\TextInput::make('stat3_label.ru')->label('Stat 3 Label (RU)'),
                        Forms\Components\TextInput::make('stat3_label.en')->label('Stat 3 Label (EN)'),
                    ]),
                ]),

            Forms\Components\Section::make('About Us Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                        ->label('About Us Image (shown on homepage)')
                        ->collection('image')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios(['4:3', '16:9', null])
                        ->maxSize(5120)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('title', 'en') ?: 'About Us'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Last Updated'),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}
