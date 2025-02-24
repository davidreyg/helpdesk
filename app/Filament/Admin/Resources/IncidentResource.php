<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AttentionTypeEnum;
use App\Enums\PriorityEnum;
use App\Filament\Admin\Resources\IncidentResource\Pages;
use App\Filament\Admin\Resources\IncidentResource\RelationManagers;
use App\Models\Incident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('incident_type')
                    ->label(__('Incident Type'))
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->label(__('Priority'))
                    ->required()
                    ->options(PriorityEnum::class),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attention_type')
                    ->label(__('Attention Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('incident_type')
                    ->label(__('Incident Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->label(__('Priority'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('validation.attributes.status'))
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color())
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
