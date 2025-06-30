<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PterodactylPlanResource\Pages;
use App\Filament\Resources\PterodactylPlanResource\RelationManagers;
use App\Models\PterodactylPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PterodactylPlanResource extends Resource
{
    protected static ?string $model = PterodactylPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Paket')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(), // Membuat field ini mengambil lebar penuh

            Forms\Components\TextInput::make('ram')
                ->required()
                ->numeric()
                ->suffix('MB')
                ->helperText('Masukkan jumlah RAM dalam Megabytes. Contoh: 1024 untuk 1GB'),

            Forms\Components\TextInput::make('disk')
                ->required()
                ->numeric()
                ->suffix('MB')
                ->helperText('Masukkan jumlah Disk dalam Megabytes. Contoh: 5120 untuk 5GB'),
                
            Forms\Components\TextInput::make('cpu')
                ->required()
                ->numeric()
                ->suffix('%')
                ->helperText('Masukkan limit CPU dalam persen. Contoh: 100 untuk 1 core'),

            Forms\Components\TextInput::make('price')
                ->label('Harga')
                ->required()
                ->numeric()
                ->prefix('Rp'),
        ])->columns(2); // Mengatur layout form menjadi 2 kolom
}

   public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable() // Membuat kolom ini bisa dicari
                    ->weight('bold'), // Menebalkan teks
                Tables\Columns\TextColumn::make('ram')
                    ->sortable()
                    ->suffix(' MB') // Menambahkan satuan
                    ->alignCenter(), // Membuat rata tengah
                Tables\Columns\TextColumn::make('disk')
                    ->sortable()
                    ->suffix(' MB')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('cpu')
                    ->sortable()
                    ->suffix(' %')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR') // Memformat sebagai mata uang Rupiah
                    ->sortable()
                    ->label('Harga'),
            ])
            ->filters([
                // Filter bisa ditambahkan di sini nanti
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
            'index' => Pages\ListPterodactylPlans::route('/'),
            'create' => Pages\CreatePterodactylPlan::route('/create'),
            'edit' => Pages\EditPterodactylPlan::route('/{record}/edit'),
        ];
    }
}
