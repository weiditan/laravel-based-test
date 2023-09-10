<?php

namespace Modules\User\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function user_builder(): Builder;
}
