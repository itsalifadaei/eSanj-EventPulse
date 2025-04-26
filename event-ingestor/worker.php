<?php

use Illuminate\Contracts\Console\Kernel;
use App\Grpc\Kernel as GrpcKernel;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

$server = new Server();

$app->make(Kernel::class)->bootstrap();

app(GrpcKernel::class)->register($server);


$server->serve(Worker::create());
