<?php

use App\User;
use Faker\Factory;
use App\Model\Contact;
use App\Model\Country;
use Illuminate\Database\Seeder;
use Symfony\Component\Finder\Finder;

class ContactsSeeder extends Seeder
{

    public function run()
    {
        Contact::truncate();

        $faker = Factory::create();

        $imagesPath = config('sleeping_owl.imagesUploadDirectory', 'images/uploads');
        $uploads = public_path($imagesPath);

        $filesObj = Finder::create()->files()->in($uploads);
        $files    = [];
        foreach ($filesObj as $file) {
            $files[] = $file->getFilename();
        }

        $countries = Country::pluck('id')->all();
        $users     = User::pluck('id')->all();

        factory(Contact::class, 20)->create()->each(function(Contact $contact) use($faker, $files, $users, $countries, $imagesPath) {
            $image = $faker->optional()->randomElement($files);

            $contact->author()->associate($faker->randomElement($users));
            $contact->country()->associate($faker->randomElement($countries));
            $contact->photo = is_null($image) ? $image : ($imagesPath.'/'.$image);

            $contact->save();
        });
    }

}
