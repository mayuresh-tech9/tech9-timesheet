<?php

namespace App\Providers;

use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Window;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
//        MenuBar::create()
//            ->label('Timesheet')
//            ->icon(storage_path('app/logo.png'))
//            ->route('logs')
//            ->width(700)
//            ->height(400);

        Window::open()
//            ->alwaysOnTop()
            ->position(100,100)
            ->rememberState()
//            ->showDevTools(false)
            ->width(400)
            ->height(400);

    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
            'memory_limit' => '512M',
            'display_errors' => '1',
            'error_reporting' => 'E_ALL',
            'max_execution_time' => '0',
            'max_input_time' => '0',
        ];
    }
}
