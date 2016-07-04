<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->actingAs(App\User::first());
        $this->faker = Faker\Factory::create();
    }

    public function testDisplayPage()
    {
        $this
            ->visit('admin/contacts')
            ->see('Contacts');
    }

    public function testEditPage()
    {
        $model = App\Model\Contact::first();

        $faker = Faker\Factory::create();

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $phone = $this->faker->phoneNumber;

        $this
            ->visit("admin/contacts/{$model->id}/edit")
            ->see('Update record in section Contacts')
            ->type($firstName, 'firstName')
            ->type($lastName, 'lastName')
            ->type($phone, 'phone')
            ->type('18.04.1984', 'birthday')
            ->press('Save')
            ->see('Record updated successfully');

        $model = $model->fresh();

        $this->assertEquals($firstName, $model->firstName);
        $this->assertEquals($lastName, $model->lastName);
        $this->assertEquals($phone, $model->phone);
    }

    public function testCreatePage()
    {
        $this
            ->visit("admin/contacts/create")
            ->see('Create record in section Contacts');

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $phone = $this->faker->phoneNumber;

        $this
            ->type($firstName, 'firstName')
            ->type($lastName, 'lastName')
            ->type($phone, 'phone')
            ->type('18.04.1984', 'birthday')
            ->press('Save')
            ->see('Update record in section Contacts');

        $model = App\Model\Contact::orderBy('id', 'desc')->first();

        $this->assertEquals($firstName, $model->firstName);
        $this->assertEquals($lastName, $model->lastName);
        $this->assertEquals($phone, $model->phone);
    }

    public function testDeletePage()
    {
        $model = App\Model\Contact::first();
        $this->delete("admin/contacts/{$model->id}/delete");
        $this->assertNull(App\Model\Contact::find($model->id));
    }
}
