<?php

declare(strict_types=1);

namespace App\Livewire\SlideOvers;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Core\Enum\Operator;
use Shopper\Core\Enum\Rule;
use Shopper\Core\Models\Collection;
use Shopper\Livewire\Components\SlideOverComponent;

/**
 * @property Forms\Form $form
 */
class CollectionRules extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public Collection $collection;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->collection->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('match_conditions')
                    ->label(__('shopper::pages/collections.conditions.products_match'))
                    ->inline()
                    ->options([
                        'all' => __('shopper::pages/collections.conditions.all'),
                        'any' => __('shopper::pages/collections.conditions.any'),
                    ]),

                Forms\Components\Repeater::make('rules')
                    ->relationship()
                    ->label(__('shopper::pages/collections.conditions.title'))
                    ->addActionLabel(__('shopper::pages/collections.conditions.add'))
                    ->schema([
                        Forms\Components\Select::make('rule')
                            ->label(__('shopper::pages/collections.conditions.choose_rule'))
                            ->options(Rule::class)
                            ->required(),

                        Forms\Components\Select::make('operator')
                            ->label(__('shopper::pages/collections.conditions.select_operator'))
                            ->options(Operator::class)
                            ->required(),

                        Forms\Components\TextInput::make('value')
                            ->label(__('shopper::forms.label.value'))
                            ->required(),
                    ])
                    ->columns(3)
                    ->defaultItems(1),
            ])
            ->statePath('data')
            ->model($this->collection);
    }

    public function store(): void
    {
        $this->collection->update($this->form->getState());

        $this->closePanel();

        Notification::make()
            ->title(__('shopper::pages/collections.conditions.update'))
            ->success()
            ->send();
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        return view('shopper::livewire.slide-overs.collection-rules');
    }
}
