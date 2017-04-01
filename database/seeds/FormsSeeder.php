<?php

use Faker\Factory;
use App\Model\Forms\Form;
use Illuminate\Database\Seeder;
use Symfony\Component\Finder\Finder;

class FormsSeeder extends Seeder
{

    public function run()
    {
        Form::truncate();

        $faker = Factory::create();

        $imagesPath = config('sleeping_owl.imagesUploadDirectory', 'images/uploads');

        $uploads = public_path($imagesPath);

        $filesObj = Finder::create()->files()->in($uploads);
        $files    = [];
        foreach ($filesObj as $file) {
            $files[] = $file->getFilename();
        }

        factory(Form::class, 30)->create()->each(function(Form $form) use($faker, $files, $imagesPath) {
            $image       = $faker->optional()->randomElement($files);
            $images      = [];
            $imagesCount = mt_rand(0, 3);
            for ($j = 0; $j < $imagesCount; $j++) {
                $img      = $faker->randomElement($files);
                $images[] = $imagesPath.$img;
            }

            $form->update([
                'image'     => is_null($image) ? $image : ($imagesPath.'/'.$image),
                'images'    => $images,
            ]);
        });
    }

}
