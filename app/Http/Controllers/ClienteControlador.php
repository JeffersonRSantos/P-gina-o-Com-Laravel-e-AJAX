<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteControlador extends Controller
{
    
    public function indexjs()
    {
        return view('indexjs');
    }
    
    public function indexjson()
    {
        return Cliente::paginate(10);
    }

}
