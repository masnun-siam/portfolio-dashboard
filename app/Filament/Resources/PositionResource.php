<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Models\Position;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $slug = 'positions';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FieldSet::make('dates')->schema([
                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?Position $record): string => $record?->created_at?->diffForHumans() ?? '-')->columns(2),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn (?Position $record): string => $record?->updated_at?->diffForHumans() ?? '-')->columns(2),

                ])->hidden(),

                Grid::make(1)->schema([
                    TextInput::make('title')->required(),

                    RichEditor::make('description')
                        ->required()->grow(),
                ]),

                Grid::make(2)->schema([
                    DatePicker::make('start')->required(),

                    DatePicker::make('end')->hint('Leave empty if still working')->nullable(),
                ]),

                Grid::make(2)->schema([
                    Select::make('experience_id')
                        ->label('Company')
                        ->relationship('experience', 'company_name')
                        ->searchable()
                        ->required(),

                    Select::make('skills')
                        ->label('Skills')
                        ->relationship('skills', 'name')
                        ->multiple()
                        ->searchable()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('url')
                                ->url(),
                            FileUpload::make('image')->image()->imageCropAspectRatio('1:1'),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),

                TextColumn::make('start')
                    ->date(),

                TextColumn::make('end')
                    ->date(),

                TextColumn::make('experience_id'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
