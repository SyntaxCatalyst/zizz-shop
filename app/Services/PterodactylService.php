<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PterodactylService
{
    protected $domain;
    protected $apiKey;
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::firstOrFail();
        $this->domain = $this->settings->pterodactyl_domain;
        $this->apiKey = $this->settings->pterodactyl_api_key;
    }

    // Ubah signature untuk menerima parameter ketiga: $websiteUserId
    public function createServer(array $orderData, string $userEmail, int $websiteUserId)
    {
        // 1. Buat atau cari User di Pterodactyl
        $password = Str::random(10);
        $userData = [
            'email' => $userEmail,
            'username' => $orderData['panel_username'],
            'first_name' => $orderData['panel_username'],
            'last_name' => 'User',
            'password' => $password,
        ];
        
        $userResponse = Http::withToken($this->apiKey)->post("{$this->domain}/api/application/users", $userData);
        $userAttributes = null;
        if ($userResponse->successful()) {
            $userAttributes = $userResponse->json('attributes');
        } elseif ($userResponse->status() == 422) {
            $usersResponse = Http::withToken($this->apiKey)->get("{$this->domain}/api/application/users?filter[email]={$userEmail}");
            $users = $usersResponse->json('data');
            if (empty($users)) {
                throw new \Exception('Gagal membuat user baru, dan user lama tidak ditemukan.');
            }
            $userAttributes = $users[0]['attributes'];
        } else {
             throw new \Exception('Gagal membuat user Pterodactyl: ' . $userResponse->body());
        }
        $userId = $userAttributes['id'];

        // 2. Ambil data Egg untuk mendapatkan detail startup dan environment
        $eggResponse = Http::withToken($this->apiKey)
            ->get("{$this->domain}/api/application/nests/{$this->settings->pterodactyl_nest_id}/eggs/{$this->settings->pterodactyl_egg_id}?include=variables");
        
        if ($eggResponse->failed()) {
            throw new \Exception('Gagal mengambil data Egg: ' . $eggResponse->body());
        }
        $eggAttributes = $eggResponse->json('attributes');
        
        $environmentVariables = [];
        if (isset($eggAttributes['relationships']['variables']['data'])) {
            foreach ($eggAttributes['relationships']['variables']['data'] as $variable) {
                $envVar = $variable['attributes']['env_variable'];
                $defaultValue = $variable['attributes']['default_value'];
                $environmentVariables[$envVar] = $defaultValue;
            }
        }
        
        
        // Membuat string deskripsi secara dinamis
        $description = "Spek: {$orderData['ram']}MB RAM, {$orderData['disk']}MB Disk, {$orderData['cpu']}% CPU." .
                       " Dipesan oleh Customer ID: {$websiteUserId} dari " . config('app.name', 'Zizz Shop');

        // 3. Buat Server
        $serverName = $orderData['plan_name'] . ' - ' . $orderData['panel_username'];
        $serverData = [
            "name" => $serverName,
            "description" => $description, // <-- Gunakan variabel deskripsi yang baru dibuat
            "user" => $userId,
            "egg" => (int) $this->settings->pterodactyl_egg_id,
            "docker_image" => $eggAttributes['docker_image'],
            "startup" => $eggAttributes['startup'],
            "environment" => $environmentVariables,
            "limits" => [
                "memory" => (int) $orderData['ram'],
                "swap" => 0,
                "disk" => (int) $orderData['disk'],
                "io" => 500,
                "cpu" => (int) $orderData['cpu']
            ],
            "feature_limits" => [ "databases" => 5, "backups" => 5, "allocations" => 5 ],
            'deploy' => [
                'locations' => [(int) $this->settings->pterodactyl_location_id],
                'dedicated_ip' => false,
                'port_range' => [],
            ],
        ];

        $serverResponse = Http::withToken($this->apiKey)->post("{$this->domain}/api/application/servers", $serverData);

        $result = $serverResponse->json();
        if ($serverResponse->failed() || isset($result['errors'])) {
            throw new \Exception('Gagal membuat server Pterodactyl: ' . json_encode($result['errors'] ?? $serverResponse->body()));
        }
        
        return [
            'username' => $userAttributes['username'],
            'password' => $password,
            'server_info' => $result['attributes'],
        ];
    }
}