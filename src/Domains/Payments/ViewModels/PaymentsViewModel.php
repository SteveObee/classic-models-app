<?php

namespace Domains\Payments\ViewModels;

use App\Models\User;
use Domains\Orders\Models\Order;
use Domains\Orders\Models\OrderDetail;
use Domains\Payments\Models\Payment;
use Domains\Shared\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentsViewModel extends ViewModel
{
    public $data;
    public function __construct(public User $user) 
    {
    }

    /**
     * @return Collection
     */
    public function payments() : LengthAwarePaginator {
        return Payment::where('customerNumber', $this->user->customer_id)
            ->orderBy('paymentDate', 'desc')
            ->paginate(5);
    }

    public function totalPaid() : string {
        return Payment::where('customerNumber', $this->user->customer_id)
            ->sum('amount');
    }

    public function oustandingBalance() : string {
        return $this->totalPaid() - OrderDetail::query()
            ->whereRelation('order', 'customerNumber', $this->user->customer_id)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['Shipped', 'Resolved', 'In Process']);
            })
            ->sum('totalCost');
    }
}
