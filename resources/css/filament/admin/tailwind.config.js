import preset from '../../../../vendor/filament/filament/tailwind.config.preset';

export default {
  presets: [preset],
  content: [
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    './resources/views/infolists/**/*.blade.php',
    './resources/views/components/forms/**/*.blade.php',
    './resources/views/components/pdf/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './vendor/statikbe/laravel-filament-chained-translation-manager/**/*.blade.php',
    './vendor/awcodes/filament-table-repeater/resources/**/*.blade.php',
    './vendor/andrewdwallo/filament-selectify/resources/views/**/*.blade.php',
  ],
};
