<?php

namespace App\Service;


class ProfileService
{
    public function updateProfile($form, $user, $em)
    {
        $user->setFirstname($form->get('firstname')->getData());
        $user->setLastname($form->get('lastname')->getData());
        $user->setBirthyear($form->get('birthyear')->getData());
        $user->setAddress($form->get('address')->getData());
        $user->setCity($form->get('city')->getData());
        $user->setCountry($form->get('country')->getData());
        $user->setJob($form->get('job')->getData());

        // Upload image
        if($form->get('image')->getData()) {
            $file = $form->get('image')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_dir_user'), $filename);
            $user->setImage($filename);
        } else {
            if($user->getImage() == null) {
                $user->setImage('default.png');
            } else {
            $user->setImage($user->getImage());
            }
        }

        // Define role
        if($form->get('roles')->getData() == 'host') {
            $user->setRoles(['ROLE_HOST']);
        } else {
            $user->setRoles(['ROLE_USER']);
        }
        
        $em->persist($user);
        $em->flush();
    }
}