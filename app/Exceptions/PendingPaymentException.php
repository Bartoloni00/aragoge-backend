<?php
namespace App\Exceptions;

use Exception;

class PendingPaymentException extends Exception
{
    protected $code = 1001; // Código de error personalizado

    public function __construct($message = "No puedes renovar esta suscripción porque tienes deudas anteriores pendientes.", $code = 1001, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
