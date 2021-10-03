<?php
namespace App\Jobs;

use App\Models\Product1C;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Parser;
use Prewk\XmlStringStreamer\Stream;
use Throwable;

class ProcessImportProduct1C implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 600;
    public $count = 0;
    public $forDelete = 0;
    protected $file;
    protected $consist = null;
    protected $barcode = null;
    protected $vendorcode = null;
    const DESCRIPTION = 'Описание';

    const VENDORCODE = 'Артикул';

    const BARCODE = 'Штрихкод';

    const REQUISITES = 'ЗначенияРеквизитов';

    const REQUISITE = 'ЗначениеРеквизита';

    const VALUE = 'Значение';

    const PROPERTIES = 'ЗначенияСвойств';

    const PROPERTIE = 'ЗначенияСвойства';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stream = new Stream\File($this->file, 1024);
        $parser = new Parser\UniqueNode(['uniqueNode' => 'Товар']);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $product1c = json_decode(json_encode(simplexml_load_string($node)), true);

            $this->getProducts($product1c);

            unset($product1c);
        }

        Log::debug('deleted: ' . $this->count);
        Log::debug('forDelete: ' . $this->forDelete);
        unlink($this->file);
    }

    public function getProducts($product1c)
    {
        \DB::connection()->disableQueryLog();

        \DB::transaction(function () use ($product1c) {
            if (Product1C::where('uuid', $product1c['Ид'])->first() && Arr::has($product1c, '@attributes')) {
                if ($product1c['@attributes']['Статус'] === 'Удален') {
                    $this->forDelete++;

                    $oldProduct = Product1C::where('uuid', $product1c['Ид'])
                        ->with('product')
                        ->with('product.categories')
                        ->with('product.attributes')
                        ->with('product.unit')
                        ->first();

                    if ($oldProduct->product()->exists()) {
                        if ($oldProduct->product->categories()->exists()) {
                            $oldProduct->product->categories()->detach();
                        }

                        if ($oldProduct->product->attributes()->exists()) {
                            $oldProduct->product->attributes()->detach();
                        }

                        $oldProduct->product->variations()->update(['product_id' => null]);

                        $oldProduct->product->forceDelete();

                        $this->count++;
                    }

                    $oldProduct->delete();
                }
            } elseif (Product1C::where('uuid', $product1c['Ид'])->first()) {
                $this->updateProduct($product1c);
            } else {
                $this->createProduct($product1c);
            }
        });
    }

    public function updateProduct($product1c)
    {
        $oldProduct = Product1C::where('uuid', $product1c['Ид'])->with('media', 'product')->first();

        if (Arr::exists($product1c, DESCRIPTION) && !empty($product1c[DESCRIPTION]) && $oldProduct->product->consist === null) {
            $oldProduct->product->consist = $product1c[DESCRIPTION];
            $oldProduct->push();
        }

        if (Arr::exists($product1c, VENDORCODE) && !empty($product1c[VENDORCODE]) && $product1c[VENDORCODE] !== $oldProduct->vendorcode) {
            $oldProduct->vendorcode = $product1c[VENDORCODE];
            $oldProduct->save();
        }

        if (Arr::exists($product1c, BARCODE) && !empty($product1c[BARCODE]) && $product1c[BARCODE] !== $oldProduct->barcode) {
            $oldProduct->barcode = $product1c[BARCODE];
            $oldProduct->save();
        }


        if (Arr::exists($product1c, REQUISITES) && Arr::has($product1c[REQUISITES][REQUISITE], 'ВесНоменклатуры')) {
            $oldProduct->weight = $product1c[REQUISITES][REQUISITE][VALUE];
            $oldProduct->save();
        }

        //Update description
        if (Arr::exists($product1c, PROPERTIES)) {
            if (Arr::has($product1c[PROPERTIES][PROPERTIE], 'Ид')) {
                if ($product1c[PROPERTIES][PROPERTIE]['Ид'] === 'f5c10840-6500-11ea-bd2a-bc5ff404141d' && $oldProduct->product->description === null) {
                    $oldProduct->product->description = $product1c[PROPERTIES][PROPERTIE][VALUE];
                    $oldProduct->push();
                }
            } else {
                foreach ($product1c[PROPERTIES][PROPERTIE] as $item) {
                    if ($item['Ид'] === 'f5c10840-6500-11ea-bd2a-bc5ff404141d' && $oldProduct->product->description === null) {
                        $oldProduct->product->description = $item[VALUE];
                        $oldProduct->push();
                    }
                }
            }
        }

        unset($oldProduct);
    }

    public function createProduct($product1c)
    {
        if (Arr::exists($product1c, BARCODE) && !empty($product1c[BARCODE])) {
            $this->barcode = $product1c[BARCODE];
        }

        if (Arr::exists($product1c, VENDORCODE) && !empty($product1c[VENDORCODE])) {
            $this->vendorcode = $product1c[VENDORCODE];
        }

        $newProduct = Product1C::create([
            'uuid' => $product1c['Ид'],
            'name' => $product1c['Наименование'],
            'barcode' => $this->barcode,
            'vendorcode' => $this->vendorcode,
        ]);

        $this->barcode = null;
        $this->vendorcode = null;


        if (Arr::exists($product1c, REQUISITES) && Arr::has($product1c[REQUISITES][REQUISITE], 'ВесНоменклатуры')) {
            $newProduct->weight = $product1c[REQUISITES][REQUISITE][VALUE];
            $newProduct->save();
        }

        if (Arr::exists($product1c, PROPERTIES)) {

            //get commission
            if (Arr::has($product1c[PROPERTIES][PROPERTIE], 'Ид')) {
                if ($product1c[PROPERTIES][PROPERTIE]['Ид'] === 'd65bfebe-e413-11e9-978e-bc5ff404141d') {
                    $newProduct->commission = str_replace(',', '.', $product1c[PROPERTIES][PROPERTIE][VALUE]);
                    $newProduct->save();
                }
            } else {
                foreach ($product1c[PROPERTIES][PROPERTIE] as $item) {
                    if ($item['Ид'] === 'd65bfebe-e413-11e9-978e-bc5ff404141d') {
                        $newProduct->commission = str_replace(',', '.', $item[VALUE]);
                        $newProduct->save();
                    }
                }
            }
        }

        unset($newProduct, $product1c);
    }

    protected function newNameImage($image, $product_name, $count = '0')
    {
        $extension = Str::afterLast($image, '.');

        return Str::slug($product_name, '-') . '-' . $count . '.' . $extension;
    }

    public function storeImage($image, $name, $product)
    {
        if (is_file(storage_path('sync/') . $image)) {
            $product->addMedia(storage_path('sync/') . $image)->usingFileName($name)->toMediaCollection('product-images');
        }

        unset($name, $image);
    }

    public function failed(Throwable $exception)
    {
        return Log::error($exception->getMessage());
    }
}