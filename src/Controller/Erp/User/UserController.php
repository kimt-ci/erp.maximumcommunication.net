<?php

namespace App\Controller\Erp\User;

use App\Entity\Erp\User\User;
use App\Form\Erp\User\UserChangePasswordType;
use App\Form\Erp\User\UserChangeProfileType;
use App\Form\Erp\User\UserCreateType;
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
 * Class UserController
 * @package App\Controller\Erp\User
 * @IsGranted("ROLE_ADMIN")
 * @Route("manage")
 */
class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/setting/users/create", name="erp_setting_users_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $objectManager
     * @return RedirectResponse|Response
     */
    public function create(Request $request, ObjectManager $objectManager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserCreateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($hash);
            $objectManager->persist($user);
            $objectManager->flush();

            $this->addFlash('success', "Utilisateur ".$user->getUsername()." cré");
            return $this->redirectToRoute('erp_setting');
        }

        return $this->render('erp/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/setting/users/{id}/delete", methods={"DELETE"}, name="erp_setting_users_delete")
     * @param Request $request
     * @param User $user
     * @param UserRepository $userRepository
     * @return Response
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
//        if (!$this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
//            return $this->redirectToRoute('erp_setting');
//        }
        $findUser = $userRepository->find($user->getId());
        if ($findUser->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($findUser);
            $em->flush();
            $this->addFlash('danger', "Utilisateur ".$findUser->getUserName()." supprimé avec succès !");
        }
        return $this->redirectToRoute('erp_setting');
    }
}
