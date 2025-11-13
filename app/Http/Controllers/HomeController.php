<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


class HomeController extends Controller {
    public function redirectToCompanies() {
        if (auth()->check()) return redirect()->route('companies.index');
        return redirect()->route('login');
    }

    
}
