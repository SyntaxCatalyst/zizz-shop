<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    // Ikon diganti agar lebih sesuai dengan pesan/surat
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        // Form ini tidak diubah sama sekali, sesuai permintaan Anda.
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Tujuan')
                // Menggunakan relationship lebih direkomendasikan untuk performa
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required(),

            Forms\Components\Textarea::make('body')
                ->label('Isi Pesan')
                ->rows(4)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom untuk menampilkan nama user berdasarkan 'user_id'
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penerima')
                    ->searchable()
                    ->sortable(),

                // Kolom untuk menampilkan judul
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),

                // Kolom untuk menampilkan isi pesan, dibatasi agar tidak terlalu panjang
                Tables\Columns\TextColumn::make('body')
                    ->label('Isi Pesan')
                    ->limit(50)
                    ->tooltip(fn (Message $record): string => $record->body), // Tampilkan isi lengkap saat hover

                // Kolom untuk status dibaca (penting untuk sistem pesan)
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean(),

                // Kolom untuk tanggal dibuat
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Kirim')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                // Filter sederhana untuk status dibaca/belum
                TernaryFilter::make('is_read')
                    ->label('Status Dibaca')
                    ->trueLabel('Sudah Dibaca')
                    ->falseLabel('Belum Dibaca')
                    ->placeholder('Semua'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Menambahkan aksi hapus
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc'); // Mengurutkan dari pesan terbaru
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            // 'view' => Pages\ViewMessage::route('/{record}'), // Menambahkan halaman view
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
