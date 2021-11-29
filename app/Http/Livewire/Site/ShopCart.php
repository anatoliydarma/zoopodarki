<?php
namespace App\Http\Livewire\Site;

use App\Models\Product1C;
use App\Traits\Discounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class ShopCart extends Component
{
    use Discounts;
    use WireToast;

    public $cartId; // индификатор корзины
    public $shelterCartId; // индификатор корзины shelter
    public $counter; // количество товара в корзине
    public $items;
    public $shelterItems;
    public $subTotal;
    public $totalWeight;

    public $currentUrl;
    protected $listeners = [
        'addToCart',
        'increment',
        'decrement',

    ];

    public function mount()
    {

        if (request()->session()->has('cart_id')) {
            $cart_id = session('cart_id');

            // foreach ($cart as $item) {
            //     if ($item['quantity'] > 21) {
            //         session()->flush();
            //     }
            // }
        }

        $this->generateId();

        $this->getCart();
    }

    public function addToCart(int $itemId, int $quantity, $categoryId = 0, int $byWeight = 0)
    {

        $cart = $this->checkShelterCategory((int)$categoryId);

        if ($cart->isEmpty()) {
            $this->add($itemId, $quantity, (int)$categoryId, $byWeight);
        } else {
            if ($cart->get($itemId) !== null) {
                if ($cart->get($itemId)->attributes->unit_value == 'на развес') {
                    $this->add($itemId, $quantity, (int)$categoryId, $byWeight);
                } else {
                    $this->increment($itemId, (int)$categoryId, $byWeight);
                }
            } else {
                $this->add($itemId, $quantity, (int)$categoryId, $byWeight);
            }
        }

        $this->getCart();
    }

    public function add(int $itemId, int $quantity, int $categoryId = 0, int $byWeight = 0)
    {

        DB::transaction(
            function () use ($itemId, $quantity, $categoryId, $byWeight) {
                $product_1c = Product1C::with('product', 'product.categories', 'product.categories.catalog')
                  ->find($itemId);

                if ($product_1c->stock < $quantity) {
                    $quantity = $product_1c->stock;
                }

                if ((int) $product_1c->stock === 0) {
                    $this->getCart();

                    $this->dispatchBrowserEvent(
                        'toast',
                        ['type' => 'error', 'text' => 'Товара больше нет в наличии']
                    );
                } else {
                    $cart = $this->checkShelterCategory($categoryId);

                    if ($categoryId === 0) {
                        $categoryId = $product_1c->product->categories[0]->id;
                    }

                    $associatedModel = [
                      'stock' => $product_1c->stock,
                      'unit_value' => $product_1c->unit_value,
                      'image' => $product_1c->product->getFirstMediaUrl('product-images', 'thumb'),
                      'category_id' => $categoryId,
                      'promotion_type' => $product_1c->promotion_type,
                      'promotion_price' => $product_1c->promotion_price,
                      'vendorcode' => $product_1c->vendorcode,
                      'catalog_slug' => $product_1c->product->categories[0]->catalog->slug,
                      'category_slug' => $product_1c->product->categories[0]->slug,
                      'product_slug' => $product_1c->product->slug,
                    ];

                    $weight = $product_1c->weight;
                    if ($product_1c->unit_value == 'на развес') {
                        $weight = $byWeight;
                    }

                    $cart->add([
                          'id' => $product_1c->id,
                          'name' => $product_1c->product->name,
                          'price' => $product_1c->price,
                          'quantity' => $quantity,
                          'attributes' => [
                              'unit' => $product_1c->product->unit,
                              'weight' => $weight,
                              'unit_value' => $product_1c->unit_value,
                          ],
                          'associatedModel' => $associatedModel,
                    ]);

                    if ($product_1c->unit_value == 'на развес') {
                        $price = ($byWeight / 1000) * $product_1c->price;

                        $cart->update($product_1c->id, array(
                         'quantity' => array(
                            'relative' => false,
                            'value' => 1
                            ),
                        'price' => $price,
                        ));
                    }

                    if ($product_1c->vendorcode !== 'DISCOUNT_CARD') {
                        $this->checkAndSetPromotionDiscount($cart, $product_1c);
                    }

                    toast()
                      ->success('Товар добавлен в корзину')
                      ->push();
                }
            }
        );
    }

    public function increment(int $itemId, int $categoryId = 0): void
    {

        $cart = $this->checkShelterCategory($categoryId);
        $item = $cart->get($itemId);


        if ($item->associatedModel['stock'] < $item->quantity + 1) {
            toast()
            ->info('Извините, товара больше нет в наличии')
            ->push();

            $this->getCart();
            $this->emitTo('product-card', 'render');
        } else {
            $cart->update(
                $itemId,
                [
                'quantity' => 1,
                ]
            );
            $this->getCart();
            $this->emitTo('product-card', 'render');
        }

        $this->reloadCartCheckout();
    }

    public function decrement(int $itemId, int $categoryId = 0): void
    {

        $cart = $this->checkShelterCategory($categoryId);

        $cart->update(
            $itemId,
            ['quantity' => -1]
        );

        $this->getCart();
        $this->emitTo('product-card', 'render');

        $this->reloadCartCheckout();
    }

    public function delete($itemId, $categoryId = 0): void
    {
        if ($itemId) {
            $cart = $this->checkShelterCategory($categoryId);
            $cart->remove($itemId);
            $this->getCart();
            $this->emitTo('product-card', 'render');
            $this->reloadCartCheckout();
        }
    }

    public function generateId(): void
    {
        if (request()->session()->missing('cart_id')) {
            $this->cartId = 'cart_id' . Str::random(10);
            session(['cart_id' => $this->cartId]);
        } else {
            $this->cartId = session('cart_id');
        }

        if (request()->session()->missing('shelter_cart')) {
            $this->shelterCartId = 'shelter_cart' . Str::random(10);
            session(['shelter_cart' => $this->shelterCartId]);
        } else {
            $this->shelterCartId = session('shelter_cart');
        }
    }

    public function getCart(): void
    {
        $cart = \Cart::session($this->cartId);

        $shelterCart = app('shelter')->session($this->shelterCartId);
        $shelterCartCounter = $shelterCart->getTotalQuantity();

        $this->counter = \Cart::session($this->cartId)->getTotalQuantity() + $shelterCartCounter;

        $functionItems = $cart->getContent();
        $this->subTotal = $cart->getSubTotal() + $shelterCart->getSubTotal();

        $this->items = $functionItems->all();

        $this->removeCheckoutDiscounts($this->items, $this->cartId);

        $functionShelterItems = $shelterCart->getContent();
        $this->shelterItems = $functionShelterItems->all();

        $this->getTotalWeight($functionItems, $functionShelterItems);
    }

    public function getTotalWeight($items, $shelterItems): void
    {
        $this->totalWeight = collect();

        if (count($items) > 0) {
            foreach ($items as $item) {
                $itemWeight = $item->attributes->weight * $item->quantity;
                $this->totalWeight->push($itemWeight);
            }
        }

        if (count($shelterItems) > 0) {
            foreach ($shelterItems as $shelterItem) {
                $itemWeight = $shelterItem->attributes->weight * $shelterItem->quantity;
                $this->totalWeight->push($itemWeight);
            }
        }

        $this->totalWeight = $this->totalWeight->sum();
    }

    public function checkShelterCategory($categoryId)
    {
        if ($categoryId === 82) { // Помоги приюту
            return $cart = app('shelter')->session($this->shelterCartId);
        } else {
            return $cart = \Cart::session($this->cartId);
        }
    }

    public function reloadCartCheckout(): void
    {
        if ($this->currentUrl === 'checkout') {
            $this->emit('getCartCheckout');
        }
    }

    public function render()
    {
        return view('livewire.site.shop-cart');
    }
}
