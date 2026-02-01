<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class UpdateOrderStatus extends Command
{
    protected $signature = 'order:update-status {orderId} {status}';

    protected $description = 'Manually update order payment status for testing purposes';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        $status = $this->argument('status');

        if (!in_array($status, ['pending', 'paid', 'failed'])) {
            $this->error('Invalid status. Allowed values: pending, paid, failed.');
            return 1;
        }

        $order = Order::find($orderId);

        if (!$order) {
            $this->error("Order with ID {$orderId} not found.");
            return 1;
        }

        $order->payment_status = $status;
        $order->save();

        $this->info("Order ID {$orderId} payment status updated to {$status}.");
        return 0;
    }
}
