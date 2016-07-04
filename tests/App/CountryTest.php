<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CountryTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->actingAs(App\User::first());
    }

    public function testDisplayPage()
    {
        $model = \App\Model\Country::orderBy('id')->skip(1)->first();

        $prevOrder = $model->order;

        $this
            ->visit('admin/countries')
            ->see('Countries (orderable)');

        $this->post("admin/countries/{$model->id}/down");

        $this->assertNotEquals($prevOrder, $model->fresh()->order);

        $this->post("admin/countries/{$model->id}/up");
        $this->assertEquals($prevOrder, $model->fresh()->order);
    }
}
