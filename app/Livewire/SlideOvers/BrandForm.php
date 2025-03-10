<?php

declare(strict_types=1);

namespace App\Livewire\SlideOvers;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Shopper\Components\Form\SeoField;
use Shopper\Components\Section;
use Shopper\Core\Repositories\BrandRepository;
use Shopper\Livewire\Components\SlideOverComponent;

/**
 * @property Form $form
 */
class BrandForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public $brand;

    public ?array $data = [];

    public function mount(?int $brandId = null): void
    {
        $this->brand = $brandId
            ? (new BrandRepository)->getById($brandId)
            : (new BrandRepository)->query()->newModelInstance();

        $this->form->fill($this->brand->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('shopper::words.general'))
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('shopper::forms.label.name'))
                            ->placeholder('Apple, Nike, Samsung...')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                                $set('slug', Str::slug($state));
                            }),
                        Components\Hidden::make('slug'),
                        Components\TextInput::make('website')
                            ->label(__('shopper::forms.label.website'))
                            ->placeholder('https://example.com')
                            ->url(),
                        Components\Toggle::make('is_enabled')
                            ->label(__('shopper::forms.label.visibility'))
                            ->helperText(__('shopper::words.set_visibility', ['name' => __('shopper::pages/brands.single')])),
                        Components\RichEditor::make('description')
                            ->label(__('shopper::forms.label.description'))
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                    ]),
                Section::make(__('shopper::words.media'))
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Components\SpatieMediaLibraryFileUpload::make('file')
                            ->label(__('shopper::forms.label.image_preview'))
                            ->collection(config('shopper.media.storage.thumbnail_collection'))
                            ->image()
                            ->maxSize(config('shopper.media.max_size.thumbnail')),
                    ]),
                Section::make(__('shopper::words.seo.slug'))
                    ->collapsible()
                    ->compact()
                    ->schema(SeoField::make()),
                Section::make('Metadata')
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Components\KeyValue::make('metadata')
                            ->reorderable(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->brand);
    }

    public function save(): void
    {
        if ($this->brand->id) {
            $this->authorize('edit_brands', $this->brand);

            $this->brand->update($this->form->getState());
        } else {
            $this->authorize('add_brands');

            $brand = (new BrandRepository)->create($this->form->getState());
            $this->form->model($brand)->saveRelationships();
        }

        Notification::make()
            ->title(__('shopper::notifications.save', ['item' => __('shopper::pages/brands.single')]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'shopper.brands.index',
            navigate: true,
        );
    }

    public function render(): View
    {
        return view('shopper::livewire.slide-overs.brand-form');
    }
}
