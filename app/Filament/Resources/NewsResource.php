<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
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

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedNewspaper;
    }

    protected static ?string $navigationLabel = 'News';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Tabs::make('Translations')
                ->columnSpanFull()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🇦🇲 Armenian (HY)')
                        ->schema([
                            Forms\Components\TextInput::make('title.hy')
                                ->label('Title (Armenian)')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) =>
                                    $set('slug', Str::slug($state . '-' . now()->timestamp))
                                ),
                            Forms\Components\Textarea::make('short_description.hy')
                                ->label('Short Description (Armenian)')
                                ->rows(3)
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('description.hy')
                                ->label('Full Description (Armenian)')
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇷🇺 Russian (RU)')
                        ->schema([
                            Forms\Components\TextInput::make('title.ru')
                                ->label('Title (Russian)'),
                            Forms\Components\Textarea::make('short_description.ru')
                                ->label('Short Description (Russian)')
                                ->rows(3)
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('description.ru')
                                ->label('Full Description (Russian)')
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇬🇧 English (EN)')
                        ->schema([
                            Forms\Components\TextInput::make('title.en')
                                ->label('Title (English)'),
                            Forms\Components\Textarea::make('short_description.en')
                                ->label('Short Description (English)')
                                ->rows(3)
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('description.en')
                                ->label('Full Description (English)')
                                ->columnSpanFull(),
                        ]),
                ]),

            Forms\Components\Section::make('Settings')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Published At')
                        ->default(now()),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ]),

            Forms\Components\Section::make('Main Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('main_image')
                        ->label('Main Image (shown on homepage card)')
                        ->collection('main_image')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios(['16:9', '4:3', null])
                        ->maxSize(5120)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Gallery')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->label('Gallery Images')
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
                Tables\Columns\SpatieMediaLibraryImageColumn::make('main_image')
                    ->collection('main_image')
                    ->conversion('thumb')
                    ->label('Image')
                    ->width(80)
                    ->height(55),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('title', 'hy', false) ?: $record->getTranslation('title', 'en', false) ?: '—')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Published'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
