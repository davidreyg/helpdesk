import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/filament/admin/theme.css',
      ],
      refresh: [
        ...refreshPaths,
        'app/Filament/**',
        'app/Forms/Components/**',
        'app/Livewire/**',
        'app/Infolists/Components/**',
        'app/Providers/Filament/**',
        'app/Tables/Columns/**',
      ],
    }),
  ],
});
