<?php

require_once __DIR__ . '/person.php';

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