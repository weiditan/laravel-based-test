<?php

namespace Modules\User\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function user_builder(): Builder;
    public function user_status_dropdown(bool $with_all = false): array;
}
