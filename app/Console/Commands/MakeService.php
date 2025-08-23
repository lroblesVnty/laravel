<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class MakeService extends Command {
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera una clase de servicio en app/Services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $name = $this->argument('name');
        $servicePath = app_path("Services/{$name}.php");

        if (File::exists($servicePath)) {
            $this->error("El servicio {$name} ya existe.");
            return;
        }
        $stub = <<<EOT
        <?php

        namespace App\Services;

        class {$name}
        {
            public function __construct()
            {
                // Constructor opcional
            }

            // Método base
            public function handle(\$data)
            {
                // Lógica del servicio
            }
        }
        EOT;

        File::ensureDirectoryExists(app_path('Services'));
        File::put($servicePath, $stub);

        $this->info("Servicio {$name} creado exitosamente en app/Services.");
    }



    
}
