<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppKeyGenerator extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "key:generate";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate app key";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'APP_KEY='.env('APP_KEY'), 'APP_KEY='.str_random(32), file_get_contents($path)
            ));
        }

        $this->comment('The app key has generated successfully !');

    }
}
