<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Miembro;

class UpdateStatusTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado del miembro';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
         $miembro = Miembro::where('id', 2)->first();
        if ($miembro) {
            $miembro->activo = true;
            $miembro->save();
        }

        return 0;
    }
}
