<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr; // <-- DITAMBAHKAN

class PterodactylService
{
    protected $domain;
    protected $apiKey;
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::first();
        $this->domain = rtrim($this->settings->pterodactyl_domain); // Remove trailing slash
        $this->apiKey = $this->settings->pterodactyl_api_key;
    }

    public function createServer(array $orderData, string $userEmail, int $websiteUserId)
    {
        try {
            // Validasi input data
            $this->validateOrderData($orderData);
            
            // 1. Buat atau cari User di Pterodactyl
            $userAttributes = $this->createOrFindUser($orderData, $userEmail);
            $userId = $userAttributes['id'];
            $password = $userAttributes['password'] ?? Str::random(10);

            // 2. Ambil data Egg untuk mendapatkan detail startup dan environment
            $eggAttributes = $this->getEggData();
            
            // 3. Buat Server
            $serverData = $this->buildServerData($orderData, $websiteUserId, $userId, $eggAttributes);
            
            Log::info('Creating Pterodactyl server with data:', $serverData);
            
            $serverResponse = Http::withToken($this->apiKey)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->timeout(30)
                ->post("{$this->domain}/api/application/servers", $serverData);

            if ($serverResponse->failed()) {
                $errorBody = $serverResponse->json();
                Log::error('Pterodactyl server creation failed:', [
                    'status' => $serverResponse->status(),
                    'response' => $errorBody,
                    'request_data' => $serverData
                ]);
                
                throw new \Exception('Gagal membuat server Pterodactyl: ' . 
                    ($errorBody['errors'][0]['detail'] ?? $serverResponse->body()));
            }

            $result = $serverResponse->json();
            
            return [
                'username' => $userAttributes['username'],
                'password' => $password,
                'server_info' => $result['attributes'],
            ];
            
        } catch (\Exception $e) {
            Log::error('Error in createServer: ' . $e->getMessage());
            throw $e;
        }
    }

    private function validateOrderData(array $orderData)
{
    // Validasi field yang tidak boleh kosong sama sekali
    $requiredText = ['panel_username', 'plan_name'];
    foreach ($requiredText as $field) {
        if (empty($orderData[$field])) {
            throw new \Exception("Field {$field} is required.");
        }
    }

    // Validasi field numerik yang boleh bernilai 0 (unlimited)
    $numericFields = ['ram', 'disk', 'cpu'];
    foreach ($numericFields as $field) {
        // SOLUSI: Hanya tolak jika field tidak ada, bukan angka, atau nilainya negatif.
        if (!isset($orderData[$field]) || !is_numeric($orderData[$field]) || $orderData[$field] < 0) {
            throw new \Exception("Field {$field} must be a valid, non-negative number.");
        }
    }
}

    private function createOrFindUser(array $orderData, string $userEmail)
    {
        $password = Str::random(10);
        $userData = [
            'email' => $userEmail,
            'username' => $orderData['panel_username'],
            'first_name' => $orderData['panel_username'],
            'last_name' => 'User',
            'password' => $password,
        ];
        
        Log::info('Creating Pterodactyl user:', Arr::except($userData, ['password'])); // <-- DIPERBAIKI
        
        $userResponse = Http::withToken($this->apiKey)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->post("{$this->domain}/api/application/users", $userData);

        if ($userResponse->successful()) {
            $attributes = $userResponse->json('attributes');
            $attributes['password'] = $password; // Store password for return
            return $attributes;
        } 
        
        if ($userResponse->status() == 422) {
            // User mungkin sudah ada, cari berdasarkan email
            $usersResponse = Http::withToken($this->apiKey)
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->timeout(30)
                ->get("{$this->domain}/api/application/users?filter[email]={$userEmail}");
            
            if ($usersResponse->successful()) {
                $users = $usersResponse->json('data');
                if (!empty($users)) {
                    Log::info('Found existing user for email: ' . $userEmail);
                    return $users[0]['attributes'];
                }
            }
            
            throw new \Exception('User dengan email tersebut tidak dapat dibuat atau ditemukan.');
        }
        
        $errorBody = $userResponse->json();
        Log::error('Failed to create Pterodactyl user:', [
            'status' => $userResponse->status(),
            'response' => $errorBody
        ]);
        
        throw new \Exception('Gagal membuat user Pterodactyl: ' . 
            ($errorBody['errors'][0]['detail'] ?? $userResponse->body()));
    }

    private function getEggData()
    {
        $eggResponse = Http::withToken($this->apiKey)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->timeout(30)
            ->get("{$this->domain}/api/application/nests/{$this->settings->pterodactyl_nest_id}/eggs/{$this->settings->pterodactyl_egg_id}?include=variables");
        
        if ($eggResponse->failed()) {
            $errorBody = $eggResponse->json();
            Log::error('Failed to get egg data:', [
                'nest_id' => $this->settings->pterodactyl_nest_id,
                'egg_id' => $this->settings->pterodactyl_egg_id,
                'response' => $errorBody
            ]);
            
            throw new \Exception('Gagal mengambil data Egg: ' . 
                ($errorBody['errors'][0]['detail'] ?? $eggResponse->body()));
        }
        
        return $eggResponse->json('attributes');
    }

    private function buildServerData(array $orderData, int $websiteUserId, int $userId, array $eggAttributes)
    {
        $description = "Spek: {$orderData['ram']}MB RAM, {$orderData['disk']}MB Disk, {$orderData['cpu']}% CPU." .
                       " Dipesan oleh Customer ID: {$websiteUserId} dari " . config('app.name', 'Zizz Shop');

        $serverName = $orderData['plan_name'] . ' - ' . $orderData['panel_username'];
        
        // Use hardcoded values like Node.js version that works
        return [
            "name" => $serverName,
            "description" => $description,
            "user" => $userId,
            "egg" => (int) $this->settings->pterodactyl_egg_id,
            "docker_image" => "ghcr.io/parkervcp/yolks:nodejs_20", // Hardcode seperti Node.js
            "startup" => $eggAttributes['startup'], // Ambil dari egg
            "environment" => [
                "INST" => "npm",
                "USER_UPLOAD" => "0",
                "AUTO_UPDATE" => "0",
                "CMD_RUN" => "npm start"
            ],
            "limits" => [
                "memory" => (int) $orderData['ram'],
                "swap" => 0,
                "disk" => (int) $orderData['disk'],
                "io" => 500,
                "cpu" => (int) $orderData['cpu']
            ],
            "feature_limits" => [
                "databases" => 5,
                "backups" => 5,
                "allocations" => 1 // Tambahkan allocations seperti Node.js
            ],
            "deploy" => [
                "locations" => [(int) $this->settings->pterodactyl_location_id],
                "dedicated_ip" => false,
                "port_range" => []
            ],
        ];
    }
}