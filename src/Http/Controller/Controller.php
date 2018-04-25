<?php

namespace Threef\Entree\Http\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Orchestra\Routing\Traits\ControllerResponse;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ControllerResponse, DispatchesJobs, ValidatesRequests;
}
