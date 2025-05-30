<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MailSettings extends Settings
{
    public string $from_address;

    public string $from_name;

    public ?string $driver = null;

    public ?string $host = null;

    public int $port;

    public string $encryption;

    public ?string $username = null;

    public ?string $password = null;

    public ?int $timeout = null;

    public ?string $local_domain = null;

    public static function group(): string
    {
        return 'mail';
    }

    public static function encrypted(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public function loadMailSettingsToConfig($data = null): void
    {
        config([
            'mail.mailers.smtp.host' => $data['host'] ?? $this->host,
            'mail.mailers.smtp.port' => $data['port'] ?? $this->port,
            'mail.mailers.smtp.encryption' => $data['encryption'] ?? $this->encryption,
            'mail.mailers.smtp.username' => $data['username'] ?? $this->username,
            'mail.mailers.smtp.password' => $data['password'] ?? $this->password,
            'mail.from.address' => $data['from_address'] ?? $this->from_address,
            'mail.from.name' => $data['from_name'] ?? $this->from_name,
        ]);
    }
}
