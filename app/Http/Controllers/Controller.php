<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Traits\QueryBuilderTrait;
use App\Http\Traits\ViewRendererTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use QueryBuilderTrait;
    use ValidatesRequests;
    use ViewRendererTrait;
}
