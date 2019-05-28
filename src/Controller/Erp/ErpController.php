<?php

namespace App\Controller\Erp;

use App\Entity\Erp\User\User;
use App\Form\Erp\User\UserChangePasswordType;
use App\Form\Erp\User\UserChangeProfileType;
use App\Repository\Erp\User\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ErpController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 * @Route("manage")
 */
class ErpController extends AbstractController
{
    /**
     * @Route("/dashboard", name="erp_dashboard")
     */
    public function dashboard()
    {
        return $this->render('erp/dashboard.html.twig');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/setting", name="erp_setting")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function setting(UserRepository $userRepository)
    {
        /** @var User[] $users */
        $users = $userRepository->findAll();

        return $this->render('erp/setting.html.twig',
            [
                "users" => $users,
                'active_setting' => "active"
            ]);
    }

    /**
     * User
     */
    /**
     * @Route("/{slug}/profile", name="erp_user_profile")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function userChangeProfile(Request $request, User $user, ObjectManager $objectManager)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserChangeProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $objectManager->flush();
            $this->addFlash('warning', "Profil modifé");

            return $this->redirectToRoute('erp_user_profile',
                [
                    'slug' => $user->getSlug()
                ]);
        }

        return $this->render('erp/user/change_profile.html.twig', [
            'form' => $form->createView(),
            'active_profile' => "active"
        ]);
    }

    /**
     * @Route("/{slug}/password", name="erp_user_password")
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $objectManager
     * @return RedirectResponse|Response
     */
    public function userChangePassword(Request $request, User $user,  UserPasswordEncoderInterface $encoder, ObjectManager $objectManager)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
//            if($encoder->isPasswordValid($user, $user->getOldPassword())) {

            $hash = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($hash);
            $objectManager->flush();
            $this->addFlash('warning', "Mot de passe modifé");
            return $this->redirectToRoute('erp_user_password',
                [
                    'slug' => $user->getSlug()
                ]);
//            } else{
//                $this->addFlash('danger', "Ancien mot de passe est incorrect");
//            }
        }

        return $this->render('erp/user/change_password.html.twig', [
            'form' => $form->createView(),
            'active_password' => "active"
        ]);
    }

}
