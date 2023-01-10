<?php

namespace Tests\Browser;

use App\CartItem;
use App\Company;
use App\Enquiry;
use App\Transaction;
use App\User;
use Database\Factories\CompanyFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BuyerTest extends DuskTestCase
{
//    /**
//     * Test add to cart
//     *
//     * @throws \Throwable
//     */
//    public function testAddToCart()
//    {
//        // Remove all existing cart items, transactions and enquiries
//        CartItem::where('user_id', 1)->delete();
//        Transaction::where('buyer_id', 1)->delete();
//        Enquiry::where('user_id', 1)->delete();
//
//        $this->browse(function (Browser $browser) {
//            $browser
//                ->loginAs(User::find(1))
//                ->visit('/app/start')
//                ->clickLink('Used Cars')
//                ->assertSeeIn('h1', 'Used cars')
//                ->click('table td:nth-child(3)')
//                ->waitFor('#slide-over-heading', 2)
//                ->assertPresent('#slide-over-heading')
//                ->press('Add to cart')
//                ->pause(200)
//                ->assertSee('Remove')
//            ;
//        });
//    }

//    public function testCart()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser
//                ->loginAs(User::find(1))
//                ->visit('/app/start')
//                ->press('@go-to-cart-button')
//                ->assertPathIs(route('cart.index', [], false))
//                ->press('Start Enquiry')
//                ->assertSeeIn('@go-to-cart-button', 0)
//            ;
//        });
//    }

    /**
     * Test order vehicle
     *
     * @throws \Throwable
     */
    public function testOrderVehicle()
    {
        $user = User::factory()
            ->has(Company::factory())
            ->create();

        $user->assignRole('Buyer');

        activity('login_success')
            ->performedOn($user)
            ->causedBy($user)
            ->log('Login success.');

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('/app/start')
                ->clickLink('Used Cars')
                ->click('@brand-button-picker')
                ->click('@brand-1-option');

            $vin = $browser->text('table td:nth-child(3)');

            $browser->click('table td:nth-child(3)')
                ->waitFor('#slide-over-heading', 5)
                ->assertPresent('#slide-over-heading')
                ->press('Add to cart')
                ->pause(200)
                ->visit('/app/cart')
                ->assertSeeIn('@cart-vin', $vin)
                ->press('Start Enquiry')
                ->assertSeeIn('@go-to-cart-button', 0)
                ->visit('/app/enquiry/buyer/enquiries?status[0]=in_progress');

            $enquiryCar = $browser->text('table td:nth-child(5)');

            $this->assertStringContainsString($vin, $enquiryCar);
            ;
        });
    }
}
