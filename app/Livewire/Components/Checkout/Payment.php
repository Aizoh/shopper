<?php

declare(strict_types=1);

namespace App\Livewire\Components\Checkout;

use App\Actions\CreateOrder;
use App\Actions\Payment\PayWithCash;
use App\Actions\Payment\PayWithMpesa;
use App\Enums\PaymentType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;
use Spatie\LivewireWizard\Components\StepComponent;
use Livewire\Attributes\On; 
use function Livewire\Volt\{state};
use Darryldecode\Cart\Facades\CartFacade;




class Payment extends StepComponent
{
    #[Validate('required', message: 'You must select a payment method')]
    public ?int $currentSelected = null;

    #[Validate('required_if:currentSelected,2', message: 'Phone number is required for Mpesa payment')]
    public ?string $phoneNumber = null;

    /**
     * @var array|Collection
     */
    public $methods = [];

    public float $price ;


    #protected $listeners = ['update-price' => 'updatePrice'];

    // #[On('update-price')] 

    // public function updatePrice($price)
    // {
    //     $this->price = $price;
    //     Log::info('Price before payment', ['price' => $this->price]);

    // }

    public function mount(): void
    {
        $countryId = data_get(session()->get('checkout'), 'shipping_address.country_id');
        $this->currentSelected = data_get(session()->get('checkout'), 'payment')
            ? data_get(session()->get('checkout'), 'payment')[0]['id']
            : null;

        $country = Country::query()->with('zones')->find($countryId);
        /** @var ?Zone $zone */
        $zone = $country->zones()
            ->where('is_enabled', true)
            ->with('paymentMethods', function ($query) {
                $query->where('is_enabled', true);
            })
            ->first();

        $this->methods = $zone ? $zone->paymentMethods : [];

        $checkout = session()->get('checkout', []);
        $shippingPrice = data_get($checkout, 'shipping_option.0.price', 0);
        $cartTotal = CartFacade::session(session()->getId())->getTotal();
    
        $this->price = (float) ($shippingPrice + $cartTotal);
        
        Log::info('Price before payment', ['price' => $this->price]);

        Log::info('Checkout session data', session()->get('checkout', []));


    }

    public function updatedCurrentSelected(): void
    {
        if ($this->currentSelected !== PaymentType::Mpesa()) {
            $this->phoneNumber = null; // Clear phone number when switching from Mpesa
        }
    }

    public function save(): void
    {
        $this->validate();

        session()->forget('checkout.payment');

        session()->push('checkout.payment', PaymentMethod::query()->find($this->currentSelected)->toArray());

        $order = (new CreateOrder)->handle();

        // match (data_get(session()->get('checkout'), 'payment')[0]['slug']) {
        //     PaymentType::Cash() => (new PayWithCash)->handle($order),
        // };
        $paymentType = data_get(session()->get('checkout'), 'payment.0.slug');

        // match ($paymentType) {
        //     PaymentType::Cash() => (new PayWithCash)->handle($order),
        //     PaymentType::Mpesa() => (new PayWithMpesa)->handle($order),
        // };
        Log::info('Price before payment', ['price' => $this->price]);
        match ($paymentType) {
            PaymentType::Cash() => (new PayWithCash)->handle($order),
            

            PaymentType::Mpesa() => (new PayWithMpesa)->handle($order, [
                'phone_number' => $this->phoneNumber,
                // 'transaction_id' => uniqid('MPESA_'),
                'status' => 'requested',
                'amount' => $this->price // Reference price here
            ]),
        };
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Payment'),
            'complete' => session()->exists('checkout')
                && data_get(session()->get('checkout'), 'payment') !== null,
        ];
    }

    public function render(): View
    {
        return view('livewire.components.checkout.payment');
    }
}
