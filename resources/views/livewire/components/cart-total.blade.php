<?php

declare(strict_types=1);

use Darryldecode\Cart\Facades\CartFacade;

use function Livewire\Volt\{on, state};
use App\Livewire\Components\Checkout\Payment;

// state(['price' => CartFacade::session(session()->getId())->getTotal()]);

// on(['cart-price-update' => function () {
//     $this->price = data_get(session()->get('checkout'), 'shipping_option')
//         ? (int) data_get(session()->get('checkout'), 'shipping_option')[0]['price'] + CartFacade::session(session()->getId())->getTotal()
//         : 0;
// }]);
// Define the initial state
state(['price' => CartFacade::session(session()->getId())->getTotal()]);

// Listen for the event and update the state
on(['cart-price-update' => function () {
    $price = data_get(session()->get('checkout'), 'shipping_option')
        ? (int) data_get(session()->get('checkout'), 'shipping_option')[0]['price'] + CartFacade::session(session()->getId())->getTotal()
        : 0;

    Log::info('cart-price-update triggered', ['price' => $price]);

    state(['price' => $price]); // Update state dynamically

    // Emit the price update event to use in the payment Controller
    // dispatch('update-price', price: $price);
    $this->dispatch('update-price', $price);

}]);

?>

<dd class="text-base">
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
