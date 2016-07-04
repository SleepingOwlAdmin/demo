<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
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
            ->visit('admin/posts')
            ->see('Posts');
    }

    public function testEditPage()
    {
        $model = App\Model\Post::first();

        $title = $this->faker->paragraph();
        $text = $this->faker->sentence();

        $this
            ->visit("admin/posts/{$model->id}/edit")
            ->see('Update record in section Posts')
            ->type($title, 'title')
            ->type($text, 'text')
            ->press('Save')
            ->see('Record updated successfully');

        $model = $model->fresh();

        $this->assertEquals($title, $model->title);
        $this->assertNotNull($model->text);
    }

    public function testCreatePage()
    {
        $this
            ->visit("admin/posts/create")
            ->see('Create record in section Posts');

        $title = $this->faker->paragraph();
        $text = $this->faker->sentence();

        $this
            ->type($title, 'title')
            ->type($text, 'text')
            ->press('Save')
            ->see('Update record in section Posts');

        $model = App\Model\Post::orderBy('id', 'desc')->first();

        $this->assertEquals($title, $model->title);
        $this->assertNotNull($model->text);
    }

    public function testDeletePage()
    {
        $model = App\Model\Post::first();

        $this->delete("admin/posts/{$model->id}/delete");

        $model = App\Model\Post::onlyTrashed()->find($model->id);

        $this->assertNotNull($model);

        $this->post("admin/posts/{$model->id}/restore");

        $model = App\Model\Post::find($model->id);
        $this->assertNotNull($model);

        $this->delete("admin/posts/{$model->id}/delete");
        $this->delete("admin/posts/{$model->id}/destroy");

        $this->assertNull(App\Model\Post::withTrashed()->find($model->id));

    }
}
