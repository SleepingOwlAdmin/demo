<?php

AdminSection::addMenuPage(\App\Model\News::class)->setItems(function() {

    AdminSection::addMenuPage()->setTitle('test')->setUrl('user/profile');

});