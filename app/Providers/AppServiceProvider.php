<?php

namespace App\Providers;

use App\Brand\BrandClass;
use App\Brand\BrandContract;
use App\Category\CategoryClass;
use App\Category\CategoryContract;
use App\PackageType\PackageTypeClass;
use App\PackageType\PackageTypeContract;
use App\Producer\ProducerClass;
use App\Producer\ProducerContract;
use App\Product\ProductClass;
use App\Product\ProductContract;
use App\ProductInfos\ProductInfosClass;
use App\ProductInfos\ProductInfosContract;
use App\Tag\TagClass;
use App\Tag\TagContract;
use App\User\UserClass;
use App\User\UserContract;
use App\Discount\DiscountClass;
use App\Discount\DiscountContract;
use App\Gallery\GalleryClass;
use App\Gallery\GalleryContract;
use App\Comment\CommentClass;
use App\Comment\CommentContract;
use App\Score\ScoreClass;
use App\Score\ScoreContract;
use App\Like\LikeClass;
use App\Like\LikeContract;
use App\ContactUs\ContactClass;
use App\ContactUs\ContactContract;
use App\Profile\ProfileClass;
use App\Profile\ProfileContract;
use App\SocialMedia\SocialMediaClass;
use App\SocialMedia\SocialMediaContract;
use App\Order\OrderClass;
use App\Order\OrderContract;
use App\Factor\FactorClass;
use App\Factor\FactorContract;
use App\Payment\PaymentClass;
use App\Payment\PaymentContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserContract::class,UserClass::class);
        $this->app->singleton(TagContract::class,TagClass::class);
        $this->app->singleton(PackageTypeContract::class,PackageTypeClass::class);
        $this->app->singleton(ProducerContract::class,ProducerClass::class);
        $this->app->singleton(BrandContract::class,BrandClass::class);
        $this->app->singleton(CategoryContract::class,CategoryClass::class);
        $this->app->singleton(ProductContract::class,ProductClass::class);
        $this->app->singleton(ProductInfosContract::class,ProductInfosClass::class);
        $this->app->singleton(DiscountContract::class,DiscountClass::class);
        $this->app->singleton(GalleryContract::class,GalleryClass::class);
        $this->app->singleton(CommentContract::class,CommentClass::class);
        $this->app->singleton(ScoreContract::class,ScoreClass::class);
        $this->app->singleton(LikeContract::class,LikeClass::class);
        $this->app->singleton(ContactContract::class,ContactClass::class);
        $this->app->singleton(ProfileContract::class,ProfileClass::class);
        $this->app->singleton(SocialMediaContract::class,SocialMediaClass::class);
        $this->app->singleton(OrderContract::class,OrderClass::class);
        $this->app->singleton(FactorContract::class,FactorClass::class);
        $this->app->singleton(PaymentContract::class,PaymentClass::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
