<?php

namespace Exceptions;

class DBConnectException{

    public function __construct($exception)
    {
        $html = "<div class='error'>Erreur de connexion à la base de données : " . $exception . "</div>";
        echo $html;
    }

}