<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyTest extends TestCase
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
        $this->visit('admin/companies')->see('Companies');
    }

    public function testEditPage()
    {
        $user = factory(App\User::class)->create();

        $model = App\Model\Company::first();

        $title = str_random('10');

        $this
            ->visit("admin/companies/{$model->id}/edit")
            ->see('Update record in section Companies')
            ->type($title, 'title')
            ->press('Save');

        $this->assertEquals($title, $model->fresh()->title);
    }

    public function testCreatePage()
    {
        $this
            ->visit("admin/companies/create")
            ->see('Create record in section Companies');

        $title = str_random('10');

        $this
            ->type('New address', 'address')
            ->press('Save')
            ->see('The Title field is required')
            ->type($title, 'title')
            ->press('Save')
            ->see('Update record in section Companies');

        $model = App\Model\Company::orderBy('id', 'desc')->first();

        $this->assertEquals($title, $model->title);
        $this->assertEquals('New address', $model->address);
    }

    public function testDeletePage()
    {
        $model = App\Model\Company::first();

        $this->delete("admin/companies/{$model->id}/delete");

        $this->assertNull(App\Model\Company::find($model->id));
    }
}
