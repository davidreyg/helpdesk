<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('mail.from_address', 'corporativo2@masterelectronics.pe');
        $this->migrator->add('mail.from_name', 'Master Electronics');
        $this->migrator->add('mail.driver', 'smtp');
        $this->migrator->add('mail.host', 'mail.masterelectronics.pe');
        $this->migrator->add('mail.port', 465);
        $this->migrator->add('mail.encryption', 'tls');
        $this->migrator->addEncrypted('mail.username', 'corporativo2@masterelectronics.pe');
        $this->migrator->addEncrypted('mail.password', null);
        $this->migrator->add('mail.timeout', null);
        $this->migrator->add('mail.local_domain', null);
    }
};
