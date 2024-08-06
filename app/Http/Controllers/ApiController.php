<?php


namespace App\Http\Controllers;


use App\Models\Account;

class ApiController
{
    public function up()
    {
        $model = new Account();
        $model->up();
    }
}
