<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkeletonPartResource\Pages;
use App\Models\SkeletonPart;
use Filament\Forms;
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

class SkeletonPartResource extends Resource
{
    protected static ?string $model = SkeletonPart::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return Heroicon::OutlinedUser;
    }

    protected static ?string $navigationLabel = 'Skeleton Parts';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Skeleton Part Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('svg_element_id')
                        ->label('SVG Element ID')
                        ->helperText('Must match the id attribute on the <g> or <path> in allbody.svg (e.g. "челюсть")')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('name_hy')
                        ->label('Armenian Name (name_hy)')
                        ->helperText('Displayed in the tooltip on the frontend (e.g. "Ծնոտ")')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->helperText('Inactive parts will not appear in the frontend tooltip.')
                        ->default(true)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('svg_element_id')
                    ->label('SVG Element ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_hy')
                    ->label('Armenian Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            ->defaultSort('svg_element_id', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSkeletonParts::route('/'),
            'create' => Pages\CreateSkeletonPart::route('/create'),
            'edit'   => Pages\EditSkeletonPart::route('/{record}/edit'),
        ];
    }
}
