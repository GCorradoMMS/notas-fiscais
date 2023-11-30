<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NotaFiscal;

class NotaFiscalPolicy
{
    public function view(User $user, NotaFiscal $notaFiscal) : bool {
        return $user->id === $notaFiscal->user_id;
    }
}
