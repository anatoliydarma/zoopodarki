<?php

namespace App\Jobs;

use App\Models\Product1C;
use App\Notifications\PromotionFinished;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckDeadlinePromotions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products1cPromotionsWithDate = Product1C::where('promotion_date', '<=', now()->toDateString())->get();

        foreach ($products1cPromotionsWithDate as $product1c) {
            $this->setPromotionFinished($product1c);
        }

        $products1cPromotionsWithNoStock = Product1C::where('promotion_type', '!=', 0)
            ->where('stock', 0)
            ->get();

        foreach ($products1cPromotionsWithNoStock as $product1c) {
            $this->setPromotionFinished($product1c);
        }
    }

    public function setPromotionFinished(Product1C $product1c)
    {
        DB::transaction(
            function () use ($product1c) {
                logger($product1c->id);

                $product1c->update([
                    'promotion_type' => 0,
                    'promotion_price' => null,
                    'promotion_percent' => null,
                    'promotion_date' => null,
                ]);

                $this->NotifyPromotionFinished($product1c->name);
            }
        );
    }

    public function NotifyPromotionFinished($name)
    {
        Notification::route('mail', [
            env('MAIL_TO_MANAGER') => 'Manager',
        ])->notify(new PromotionFinished($name));
    }
}
