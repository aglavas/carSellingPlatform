<?php

namespace Tests\Browser;

use App\Company;
use App\Imports\StockFCAImport;
use App\Imports\StockMercedesImport;
use App\Imports\StockOpelImport;
use App\Imports\StockPeugeotCitroenDsImport;
use App\StockFCA;
use App\StockMercedes;
use App\StockOpel;
use App\StockPeugeotCitroenDs;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NcUploadTest extends DuskTestCase
{
    /**
     * @throws \Exception
     */
    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub

        $opel = new StockOpel();
        $opel->delete();

        $mercedes = new StockMercedes();
        $mercedes->delete();

        $pcds = new StockPeugeotCitroenDs();
        $pcds->delete();

        $fca = new StockFCA();
        $fca->delete();
    }

    /**
     * Test Opel upload
     *
     * @throws \Throwable
     */
    public function testOpelUpload()
    {
        $filePath = storage_path("test-lists") . "/opel.xlsx";

        $user = User::factory([
            'stock_type' => 'NC'
        ])
        ->has(Company::factory())
        ->create();

        $user->assignRole('Uploader');

        activity('login_success')
            ->performedOn($user)
            ->causedBy($user)
            ->log('Login success.');

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser
                ->loginAs($user)
                ->visit('/app/start')
                ->clickLink('Upload List')
                ->select('list-type',StockOpelImport::class)
                ->waitFor('input.upload', 3)
                ->attach('input.upload', $filePath)
                ->waitFor('input.upload', 3)
                ->screenshot('error')
                ->waitFor('button[type="submit"]', 3)
                ->press('Upload List');
        });


        $this->assertDatabaseHas('stock_opel', [
            'caf' => '0001XRLK'
        ]);

        $this->assertDatabaseHas('stock_opel', [
            'caf' => '0003XNP6'
        ]);

        $this->assertDatabaseHas('stock_opel', [
            'caf' => '0003XC84'
        ]);
    }

    /**
     * Test Mercedes upload
     *
     * @throws \Throwable
     */
    public function testMercedesUpload()
    {
        $filePath = storage_path("test-lists") . "/mercedes.xlsx";

        $user = User::factory([
            'stock_type' => 'NC'
        ])
            ->has(Company::factory())
            ->create();

        $user->assignRole('Uploader');

        activity('login_success')
            ->performedOn($user)
            ->causedBy($user)
            ->log('Login success.');

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser
                ->loginAs($user)
                ->visit('/app/start')
                ->clickLink('Upload List')
                ->select('list-type',StockMercedesImport::class)
                ->waitFor('input.upload', 3)
                ->attach('input.upload', $filePath)
                ->waitFor('input.upload', 3)
                ->screenshot('error')
                ->waitFor('button[type="submit"]', 3)
                ->press('Upload List');
        });


        $this->assertDatabaseHas('stock_mercedes', [
            'an' => '0055411084'
        ]);

        $this->assertDatabaseHas('stock_mercedes', [
            'an' => '0955411116'
        ]);

        $this->assertDatabaseHas('stock_mercedes', [
            'an' => '0999911122'
        ]);

        $this->assertDatabaseHas('stock_mercedes', [
            'an' => '0955411124'
        ]);
    }

    /**
     * Test Fca upload
     *
     * @throws \Throwable
     */
    public function testFcaUpload()
    {
        $filePath = storage_path("test-lists") . "/fca.xlsx";

        $user = User::factory([
            'stock_type' => 'NC'
        ])
            ->has(Company::factory())
            ->create();

        $user->assignRole('Uploader');

        activity('login_success')
            ->performedOn($user)
            ->causedBy($user)
            ->log('Login success.');

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser
                ->loginAs($user)
                ->visit('/app/start')
                ->clickLink('Upload List')
                ->select('list-type',StockFCAImport::class)
                ->waitFor('input.upload', 3)
                ->attach('input.upload', $filePath)
                ->waitFor('input.upload', 3)
                ->screenshot('error')
                ->waitFor('button[type="submit"]', 3)
                ->press('Upload List');
        });


        $this->assertDatabaseHas('stock_fca', [
            'ident' => '49870'
        ]);

        $this->assertDatabaseHas('stock_fca', [
            'ident' => '49147'
        ]);

        $this->assertDatabaseHas('stock_fca', [
            'ident' => '49676'
        ]);

        $this->assertDatabaseHas('stock_fca', [
            'ident' => '12943'
        ]);

        $this->assertDatabaseHas('stock_fca', [
            'ident' => '13825'
        ]);

        $this->assertDatabaseHas('stock_fca', [
            'ident' => '19925'
        ]);
    }

    /**
     * Test Pcds upload
     *
     * @throws \Throwable
     */
    public function testPcdsUpload()
    {
        $filePath = storage_path("test-lists") . "/pcd.xlsx";

        $user = User::factory([
            'stock_type' => 'NC'
        ])
            ->has(Company::factory())
            ->create();

        $user->assignRole('Uploader');

        activity('login_success')
            ->performedOn($user)
            ->causedBy($user)
            ->log('Login success.');

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser
                ->loginAs($user)
                ->visit('/app/start')
                ->clickLink('Upload List')
                ->select('list-type',StockPeugeotCitroenDsImport::class)
                ->waitFor('input.upload', 3)
                ->attach('input.upload', $filePath)
                ->waitFor('input.upload', 3)
                ->screenshot('error')
                ->waitFor('button[type="submit"]', 3)
                ->press('Upload List');
        });


        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583152'
        ]);

        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583153'
        ]);

        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583256'
        ]);

        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583257'
        ]);

        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583258'
        ]);

        $this->assertDatabaseHas('stock_peugeot_citroen_ds', [
            'caf' => '91583259'
        ]);
    }
}
