<?php

namespace App\Http\Web\Controllers;

use App\ViewModels\DashboardViewModel;
use Domains\Orders\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke() {

        return Inertia::render('Dashboard', [
            'model' => new DashboardViewModel(Auth::user())
        ]);
    }
}
