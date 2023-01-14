<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Domain;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Theme;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use App\Models\Customer;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
            ->count(10)
            ->for(Gallery::factory())
            ->create();

        $users->each(function ($user) {

            $shops = Shop::factory()
                ->count(5)
                ->for($user)
                ->for(Gallery::factory())
                ->for(Theme::factory()->for(Gallery::factory()))
                ->create();

            Ticket::factory()
                ->count(5)
                ->for($user)
                ->for(Gallery::factory())
                ->create();

            Address::factory()
                ->count(5)
                ->for($user)
                ->for(Province::find(rand(1, 31)))
                ->for(City::find(rand(1, 31)))
                ->create();

            Customer::factory()
                ->count(5)
                ->for(Province::find(rand(1, 31)))
                ->for(City::find(rand(1, 31)))
                ->create();

            $shops->each(function ($shop) use ($user) {
                Domain::factory()
                    ->count(5)
                    ->for($shop)
                    ->for($user)
                    ->create();

                Article::factory()
                    ->count(5)
                    ->for($user)
                    ->for($shop)
                    ->for(Gallery::factory())
                    ->has(Comment::factory()->count(3)->for($shop))
                    ->has(ArticleCategory::factory()->count(3)->for($user)->for($shop))
                    ->create();

                Discount::factory()
                    ->for($user)
                    ->has(Product::factory()
                        ->count(5)
                        ->for($user)
                        ->for($shop)
                        ->has(Comment::factory()->count(3)->for($shop))
                        ->has(Gallery::factory()->count(3))
                        ->has(Option::factory()->count(3))
                        ->has(Category::factory()->count(3)->for($user)->for($shop))
                    )
                    ->create();
            });
        });
    }
}
