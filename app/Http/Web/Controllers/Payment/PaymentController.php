<?php

namespace App\Http\Web\Controllers\Payment;

use App\Http\Web\Controllers\Controller;
use Domains\Payments\ViewModels\PaymentsViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index() : Response {
        return Inertia::Render('Payments', [
            'model' => new PaymentsViewModel(Auth::user())
        ]);
    }
}
