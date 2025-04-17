<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AttentionTypeEnum;
use App\Enums\PriorityEnum;
use App\Filament\Admin\Resources\IncidentResource\Pages;
use App\Models\Incident;
use App\States\Incident\Rejected;
use App\States\Incident\Solved;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'tabler-clipboard-text';

    public static function getModelLabel(): string
    {
        return __('Incident');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('attention_date')
                    ->label(__('Attention Date'))
                    ->default(now()),
                Forms\Components\Select::make('attention_type')
                    ->label(__('Attention Type'))
                    ->required()
                    ->live()
                    ->options(AttentionTypeEnum::class),
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->required()
                    ->prefix(function (Get $get) {
                        $attention_type = $get('attention_type');
                        if (isset($attention_type)) {
                            return str($attention_type)->upper()->substr(0, 3);
                        }
                    })
                    ->maxLength(100),
                Forms\Components\Select::make('company_id')
                    ->label(__('Company'))
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->label(__('Priority'))
                    ->required()
                    ->options(PriorityEnum::class),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('media')
                    ->multiple()
                    ->maxFiles(3)
                    ->collection('files')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attention_date')
                    ->label(__('Attention Date'))
                    ->date(),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attention_type')
                    ->label(__('Attention Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label(__('Company'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->label(__('Priority'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('validation.attributes.status'))
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->icon(fn ($state) => $state->icon())
                    ->color(fn ($state) => $state->color())
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('solve')
                        ->label(__('Solve'))
                        ->visible(fn (Incident $record) => $record->status->canTransitionTo(Solved::class))
                        ->icon(fn (Incident $record): string => new Solved($record)->icon())
                        ->color(fn (Incident $record): string => new Solved($record)->color())
                        ->action(fn (Incident $record) => $record->status->transitionTo(Solved::class)),
                    Tables\Actions\Action::make('reject')
                        ->label(__('Reject'))
                        ->visible(fn (Incident $record) => $record->status->canTransitionTo(Rejected::class))
                        ->icon(fn (Incident $record): string => new Rejected($record)->icon())
                        ->color(fn (Incident $record): string => new Rejected($record)->color())
                        ->action(fn (Incident $record) => $record->status->transitionTo(Rejected::class)),
                ])
                    ->outlined()
                    ->icon('tabler-rotate-clockwise-2')
                    ->hiddenLabel(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIcidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
