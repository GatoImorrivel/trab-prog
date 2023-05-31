<?php

require_once __DIR__ . '/model.php';

class Person extends Model {
    protected $table = "person";

    protected $columns = [
        "idPerson",
        "email",
        "name",
        "password",
        "photo",
        "birth",
        "cellphone",
        "createdOn",
        "sysWhats",
        "sysConfirmEmail",
        "sysConfirmTerms"
    ];
}