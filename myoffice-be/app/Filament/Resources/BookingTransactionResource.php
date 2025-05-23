<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Twilio\Rest\Client;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Customer Name'),

                Forms\Components\TextInput::make('booking_trx_id')
                    ->required()
                    ->maxLength(255)
                    ->label('Transaction ID'),

                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255)
                    ->label('Phone Number'),

                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->label('Total Amount'),

                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->prefix('Days'),

                Forms\Components\DatePicker::make('started_date')
                    ->required()
                    ->label('Started at'),

                Forms\Components\DatePicker::make('ended_date')
                    ->required()
                    ->label('Ended at'),

                Forms\Components\Select::make('is_paid')
                    ->options([
                        true => 'Paid',
                        false => 'Unpaid',
                    ])
                    ->required()
                    ->label('Payment Status'),


                Forms\Components\Select::make('office_space_id')
                    ->relationship('officeSpace', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Office Space'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable()
                    ->label('Transaction ID'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Customer Name'),

                Tables\Columns\TextColumn::make('officeSpace.name')
                    ->label('Office Space'),

                Tables\Columns\TextColumn::make('started_date')
                    ->date()
                    ->label('Started at'),

                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Payment Status'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label(''),
                Tables\Actions\DeleteAction::make()
                ->label(''),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (BookingTransaction $record) {
                        $record->update(['is_paid' => true]);
                        // $record->is_paid = true;
                        $record->save();

                        // Trigger send notification to the user
                        Notification::make()
                            ->title('Booking Approved')
                            ->body('Booking for transaction ID ' . $record->booking_trx_id . ' has been approved')
                            ->success()
                            ->send();

                        $sid = getenv('TWILIO_SID');
                        $token = getenv('TWILIO_AUTH_TOKEN');
                        $twilio = new Client($sid, $token);

                        $messageBody = "Hi {$record->name}, Booking Anda dengan kode {$record->booking_trx_id} telah disetujui.\n\n";
                        $messageBody = "Terimakasih telah booking di kantor {$record->officeSpace->name}.";

                        $message = $twilio->messages->create(
                            "+{$record->phone_number}",
                            [
                                'from' => getenv('TWILIO_PHONE_NUMBER'),
                                'body' => $messageBody,
                            ]
                        );

                        // //send whatsapp
                        // $twilio->messages->create(
                        //     "whatsapp:+{$record->phone_number}",
                        //     [
                        //         'from' => "whatsapp:" . getenv('TWILIO_PHONE_NUMBER'),
                        //         'body' => $messageBody,
                        //     ]
                        // );
                    })
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn(BookingTransaction $record): bool => !$record->is_paid),
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
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
