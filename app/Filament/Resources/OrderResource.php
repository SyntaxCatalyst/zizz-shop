<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Membuat form menjadi 2 kolom
            Forms\Components\Group::make()
                ->schema([
                    // Menampilkan nama user, tidak bisa diedit
                    Forms\Components\TextInput::make('user.name')
                        ->label('Customer')
                        ->disabled(),

                    Forms\Components\TextInput::make('order_number')
                        ->disabledOn('edit'), // Tidak bisa diedit saat mode edit

                    
Forms\Components\TextInput::make('total_amount')
    ->prefix('Rp') 
    ->numeric()
    ->disabled(),
                ])->columns(2),

            // Mengubah input status menjadi Dropdown/Select
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'completed' => 'Completed',
                    'failed' => 'Failed',
                    'canceled' => 'Canceled',
                ])
                ->required(),

            // Menampilkan payment_details sebagai Textarea read-only
            Forms\Components\Textarea::make('payment_details')
                ->rows(8)
                ->disabled()
                ->helperText('Data JSON dari payment gateway.'),
        ]);
}

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('user_id')
    //                 ->required()
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('order_number')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('total_amount')
    //                 ->required()
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('status')
    //                 ->required(),
    //             Forms\Components\Textarea::make('payment_details')
    //                 ->columnSpanFull(),
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            // ->columns([
            //     Tables\Columns\TextColumn::make('user_id')
            //         ->numeric()
            //         ->sortable(),
            //     Tables\Columns\TextColumn::make('order_number')
            //         ->searchable(),
            //     Tables\Columns\TextColumn::make('total_amount')
            //         ->numeric()
            //         ->sortable(),
            //     Tables\Columns\TextColumn::make('status'),
            //     Tables\Columns\TextColumn::make('created_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            //     Tables\Columns\TextColumn::make('updated_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            // ])
            ->columns([
    Tables\Columns\TextColumn::make('order_number')
        ->searchable()
        ->copyable()
        ->label('Order Number'),

    // Menampilkan nama user, bukan hanya ID
    Tables\Columns\TextColumn::make('user.name')
        ->searchable()
        ->sortable(),

    // Mengubah status menjadi badge berwarna
    Tables\Columns\BadgeColumn::make('status')
        ->colors([
            'warning' => 'pending',
            'info' => 'processing',
            'success' => 'completed',
            'danger' => 'failed',
            'secondary' => 'canceled',
        ])
        ->sortable(),

    Tables\Columns\TextColumn::make('total_amount')
        ->money('IDR')
        ->sortable(),

    Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
