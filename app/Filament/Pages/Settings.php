<?php

namespace App\Filament\Pages;

use App\Models\Setting; // <-- Gunakan model kita
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Ambil baris pertama dari tabel settings, atau buat baru jika kosong
        // Ini akan memastikan selalu ada 1 baris untuk di-update
        $settings = Setting::firstOrCreate([]);
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        // Definisi form tidak perlu diubah
        return $form
            ->schema([
                // Forms\Components\Section::make('Integrasi OkeConnect')
                //     ->schema([
                //         Forms\Components\TextInput::make('okeconnect_merchant_id')->label('Merchant ID'),
                //         Forms\Components\TextInput::make('okeconnect_api_key')->label('API Key')->password(),
                //     ]),
                // Forms\Components\Section::make('Integrasi Generator QRIS')
                //     ->schema([
                //         Forms\Components\TextInput::make('qris_generator_codeqr')->label('Code QR Statis'),
                //     ]),
                Forms\Components\Section::make('Integrasi Pterodactyl')
                    ->description('Pengaturan untuk API Panel Pterodactyl.')
                    ->schema([
                        Forms\Components\TextInput::make('pterodactyl_domain')
                            ->label('Domain Panel')
                            ->url()
                            ->placeholder(fn () => config('services.pterodactyl.domain') ? 'Loaded from .env: ' . config('services.pterodactyl.domain') : 'https://panel.domain.com')
                            ->helperText(fn () => config('services.pterodactyl.domain') ? 'Leave empty to use .env value' : null),

                        Forms\Components\TextInput::make('pterodactyl_api_key')
                            ->label('Application API Key (ptla_)')
                            ->password()
                            ->placeholder(fn () => config('services.pterodactyl.key') ? 'Loaded from .env' : null)
                            ->helperText(fn () => config('services.pterodactyl.key') ? 'Leave empty to use .env value' : null),

                        Forms\Components\TextInput::make('pterodactyl_nest_id')
                            ->label('Nest ID')
                            ->numeric()
                            ->placeholder(fn () => config('services.pterodactyl.nest_id') ? 'Loaded from .env: ' . config('services.pterodactyl.nest_id') : null),

                        Forms\Components\TextInput::make('pterodactyl_egg_id')
                            ->label('Egg ID')
                            ->numeric()
                            ->placeholder(fn () => config('services.pterodactyl.egg_id') ? 'Loaded from .env: ' . config('services.pterodactyl.egg_id') : null),

                        Forms\Components\TextInput::make('pterodactyl_location_id')
                            ->label('Location ID')
                            ->numeric()
                            ->placeholder(fn () => config('services.pterodactyl.location_id') ? 'Loaded from .env: ' . config('services.pterodactyl.location_id') : null),
                    ]),
                Forms\Components\Section::make('Kontak & Sosial Media')
                    ->schema([
                        Forms\Components\TextInput::make('support_whatsapp_number')->label('Nomor WhatsApp CS'),
                        Forms\Components\TextInput::make('support_telegram_username')
                            ->label('Username Telegram CS')
                            ->placeholder('contoh: zizzshop_admin (tanpa @)')
                            ->helperText('Jika diisi, pelanggan akan diarahkan ke Telegram setelah checkout produk.'),
                        Forms\Components\TextInput::make('support_email')->label('Alamat Email CS')->email(),
                        Forms\Components\TextInput::make('support_instagram_url')->label('URL Instagram')->url(),
                        Forms\Components\TextInput::make('support_facebook_url')->label('URL Facebook')->url(),
                    ]),
                Forms\Components\Section::make('Template Notifikasi')
                    ->schema([
                        Forms\Components\Textarea::make('whatsapp_order_template')
                            ->label('Template Pesan WhatsApp untuk Pesanan Baru')
                            ->rows(15)
                            ->helperText('Gunakan placeholder: {nama_penerima}, {detail_pesanan}, {total_pembayaran}, {order_number}')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Pengaturan Struk')
                    ->schema([
                        Forms\Components\Textarea::make('receipt_footer_text')->label('Teks Footer Struk')->rows(3),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        // Logika save menjadi sangat sederhana dan anti-error
        $settings = Setting::first();
        $settings->update($this->form->getState());

        Notification::make()->title('Pengaturan berhasil disimpan')->success()->send();
        Artisan::call('optimize:clear');
        $this->redirect(static::getUrl());
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }
}
