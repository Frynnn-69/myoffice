<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeSpaceResource\Pages;
use App\Filament\Resources\OfficeSpaceResource\RelationManagers;
use App\Models\OfficeSpace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficeSpaceResource extends Resource
{
    protected static ?string $model = OfficeSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->helperText('Enter the name of the office space')
                ->required()
                ->maxLength(255)
                ->label('Office Space Name'),

                Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\Textarea::make('about')
                ->required()
                ->rows(10)
                ->cols(20),

                Forms\Components\Repeater::make('photos')
                ->relationship('photos')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                    ->required(),
                ]),

                Forms\Components\Repeater::make('benefits')
                ->relationship('benefits')
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Benefit Name'),
                ]),

                Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\TextInput::make('duration')
                ->required()
                ->numeric()
                ->prefix('Days'),

                Forms\Components\Select::make('is_open')
                ->options([
                    true => 'Open',
                    false => 'Closed',
                ])
                ->required()
                ->label('Status'),

                Forms\Components\Select::make('is_full_booked')
                ->options([
                    true => 'Not Available',
                    false => 'Available',
                ])
                ->required()
                ->label('Availability'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Office Space Name'),

                tables\Columns\TextColumn::make('city.name'),

                tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(function ($state) {
                        return 'IDR ' . number_format($state, 0, ',', '.');
                    }),

                tables\Columns\TextColumn::make('duration'),
                
                tables\Columns\ImageColumn::make('thumbnail'),
                
                tables\Columns\IconColumn::make('is_full_booked')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->label('Availability'),
            ])
            ->filters([
                SelectFilter::make('city_id')
                ->label('City')
                ->relationship('city', 'name'),

                SelectFilter::make('price')
                ->label('Price')
                ->options([
                    '0-1000000' => 'IDR 0 - IDR 1.000.000',
                    '1000000-3000000' => 'IDR 1.000.000 - IDR 3.000.000',
                    '3000000-5000000' => 'IDR 3.000.000 - IDR 5.000.000',
                    '5000000-10000000' => 'IDR 5.000.000 - IDR 10.000.000',
                ])
                ->query(function (Builder $query, array $data) {
                    if (isset($data['value'])) {
                        [$min, $max] = explode('-', $data['value']);
                        return $query->whereBetween('price', [(int)$min, (int)$max]);
                    }
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label(''),
                Tables\Actions\DeleteAction::make()
                ->label(''),
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
            'index' => Pages\ListOfficeSpaces::route('/'),
            'create' => Pages\CreateOfficeSpace::route('/create'),
            'edit' => Pages\EditOfficeSpace::route('/{record}/edit'),
        ];
    }
}
