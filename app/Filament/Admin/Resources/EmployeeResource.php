<?php

namespace App\Filament\Admin\Resources;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use App\Filament\Admin\Resources\EmployeeResource\Pages;
use App\Filament\Admin\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'tabler-friends';

    public static function getModelLabel(): string
    {
        return __('Employee');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('names')
                    ->label(__('Names'))
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('paternal_surname')
                    ->label(__('Paternal Surname'))
                    ->required()
                    ->maxLength(200),
                Forms\Components\TextInput::make('maternal_surname')
                    ->label(__('Maternal Surname'))
                    ->required()
                    ->maxLength(200),
                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('birth_date')
                    ->label(__('Birth Date'))
                    ->required(),
                Forms\Components\Select::make('document_type')
                    ->label(__('Document Type'))
                    ->required()
                    ->options(DocumentTypeEnum::class),
                Forms\Components\TextInput::make('document_number')
                    ->label(__('Document Number'))
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('gender')
                    ->label(__('Gender'))
                    ->required()
                    ->options(GenderEnum::class),
                Forms\Components\TextInput::make('address')
                    ->label(__('Address'))
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('names')
                    ->label(__('Names'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('paternal_surname')
                    ->label(__('Paternal Surname'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('maternal_surname')
                    ->label(__('Maternal Surname'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label(__('Birth Date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->label(__('Document Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->label(__('Document Number'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label(__('Gender'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->searchable(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
