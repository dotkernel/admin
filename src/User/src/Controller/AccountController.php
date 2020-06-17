<?php

namespace Frontend\User\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\App\Common\Message;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Entity\User;
use Frontend\User\Entity\UserInterface;
use Frontend\User\Entity\UserResetPassword;
use Frontend\User\Form\ProfileDeleteForm;
use Frontend\User\Form\ProfileDetailsForm;
use Frontend\User\Form\ProfilePasswordForm;
use Frontend\User\Form\RequestResetPasswordForm;
use Frontend\User\Form\ResetPasswordForm;
use Frontend\User\Form\UploadAvatarForm;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Dot\AnnotatedServices\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
use Exception;

class AccountController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /** @var UserService $userService */
    protected UserService $userService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @Inject({
     *     UserService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class
     *     })
     */
    public function __construct(
        UserService $userService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms
    ) {
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
    }

    /**
     * @return ResponseInterface
     */
    public function activateAction(): ResponseInterface
    {
        $hash = $this->getRequest()->getAttribute('hash', false);
        if (!$hash) {
            $this->messenger->addError(sprintf(Message::MISSING_PARAMETER, 'hash'), 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        /** @var User $user */
        $user = $this->userService->findOneBy(['hash' => $hash]);
        if (!($user instanceof User)) {
            $this->messenger->addError(Message::INVALID_ACTIVATION_CODE, 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        if ($user->getStatus() === User::STATUS_ACTIVE) {
            $this->messenger->addError(Message::USER_ALREADY_ACTIVATED, 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        try {
            $user = $this->userService->activateUser($user);
        } catch (\Exception $exception) {
            $this->messenger->addError($exception->getMessage(), 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        $this->messenger->addSuccess(Message::USER_ACTIVATED_SUCCESSFULLY, 'user-login');
        return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
    }

    /**
     * @return ResponseInterface
     */
    public function unregisterAction(): ResponseInterface
    {
        $hash = $this->getRequest()->getAttribute('hash', false);
        if (! $hash) {
            $this->messenger->addError(sprintf(Message::MISSING_PARAMETER, 'hash'), 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        $user = $this->userService->findOneBy(['hash' => $hash]);
        if (!($user instanceof User)) {
            $this->messenger->addError(Message::INVALID_ACTIVATION_CODE, 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        if ($user->isDeleted() === User::IS_DELETED_YES) {
            $this->messenger->addError(Message::USER_ALREADY_DEACTIVATED, 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        try {
            $user = $this->userService->updateUser($user, ['isDeleted' => User::IS_DELETED_YES]);
        } catch (\Exception $exception) {
            $this->messenger->addError($exception->getMessage(), 'user-login');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        $this->messenger->addSuccess(Message::USER_DEACTIVATED_SUCCESSFULLY, 'user-login');
        return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
    }

    /**
     * @return ResponseInterface
     */
    public function requestResetPasswordAction(): ResponseInterface
    {
        $form = new RequestResetPasswordForm();

        if (RequestMethodInterface::METHOD_POST === $this->getRequest()->getMethod()) {
            $form->setData($this->getRequest()->getParsedBody());
            if (!$form->isValid()) {
                $this->messenger->addError($this->forms->getMessages($form), 'request-reset');
                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            $user = $this->userService->findOneBy(['identity' => $form->getData()['identity']]);
            if (!($user instanceof User)) {
                $this->messenger->addInfo(Message::MAIL_SENT_RESET_PASSWORD, 'request-reset');
                return new RedirectResponse($this->getRequest()->getUri());
            }

            try {
                $user = $this->userService->updateUser($user->createResetPassword());
            } catch (\Exception $exception) {
                $this->messenger->addError($exception->getMessage(), 'request-reset');
                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            try {
                $this->userService->sendResetPasswordRequestedMail($user);
            } catch (\Exception $exception) {
                $this->messenger->addError($exception->getMessage(), 'request-reset');
                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            $this->messenger->addInfo(Message::MAIL_SENT_RESET_PASSWORD, 'request-reset');
            return new RedirectResponse($this->getRequest()->getUri());
        }

        return new HtmlResponse(
            $this->template->render('user::request-reset-form', [
                'form' => $form
            ])
        );
    }

    /**
     * @return ResponseInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function resetPasswordAction(): ResponseInterface
    {
        $form = new ResetPasswordForm();
        $hash = $this->getRequest()->getAttribute('hash') ?? null;
        if ($this->getRequest()->getMethod() === RequestMethodInterface::METHOD_POST) {
            $user = $this->userService->findByResetPasswordHash($hash);
            if (!($user instanceof User)) {
                $this->messenger->addError(
                    sprintf(Message::RESET_PASSWORD_NOT_FOUND, $hash),
                    'reset-password'
                );

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            /** @var UserResetPassword $resetPasswordRequest */
            $resetPasswordRequest = $user->getResetPasswords()->current();
            if (!$resetPasswordRequest->isValid()) {
                $this->messenger->addError(sprintf(Message::RESET_PASSWORD_EXPIRED, $hash), 'reset-password');

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }
            if ($resetPasswordRequest->isCompleted()) {
                $this->messenger->addError(sprintf(Message::RESET_PASSWORD_USED, $hash), 'reset-password');

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            $form->setData($this->getRequest()->getParsedBody());
            if (!$form->isValid()) {
                $this->messenger->addError($this->forms->getMessages($form), 'reset-password');

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            try {
                $this->userService->updateUser(
                    $resetPasswordRequest->markAsCompleted()->getUser(),
                    $form->getData()
                );
            } catch (\Exception $exception) {
                $this->messenger->addError($exception->getMessage(), 'reset-password');

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }

            try {
                $this->userService->sendResetPasswordCompletedMail($user);
            } catch (\Exception $exception) {
                $this->messenger->addError($exception->getMessage(), 'reset-password');

                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }
            $this->messenger->addSuccess(Message::PASSWORD_RESET_SUCCESSFULLY, 'user-login');

            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }

        return new HtmlResponse(
            $this->template->render('user::reset-password-form', [
                'form' => $form
            ])
        );
    }


    /**
     * @return ResponseInterface
     */
    public function avatarAction(): ResponseInterface
    {
        $user = $this->authenticationService->getIdentity();
        $form = new UploadAvatarForm();
        if (RequestMethodInterface::METHOD_POST === $this->request->getMethod()) {
            $file = $this->request->getUploadedFiles()['avatar']['image'] ?? '';
            if ($file->getSize() === 0) {
                $this->messenger->addWarning('Please select a file for upload.', 'profile-avatar');
                return new RedirectResponse($this->router->generateUri(
                    "account",
                    ['action' => 'avatar']
                ));
            }

            try {
                $this->userService->updateUser($user, ['avatar' => $file]);
            } catch (Exception $e) {
                $this->messenger->addError('Something went wrong updating your profile image!', 'profile-avatar');
                return new RedirectResponse($this->router->generateUri(
                    "account",
                    ['action' => 'avatar']
                ));
            }
            $this->messenger->addSuccess('Profile image updated successfully!', 'profile-avatar');
            return new RedirectResponse($this->router->generateUri(
                "account",
                ['action' => 'avatar']
            ));
        }

        return new HtmlResponse(
            $this->template->render('user::profile', [
                'action' => 'avatar',
                'content' => $this->template->render('profile::avatar', [
                    'userUploadsBaseUrl' => 'http://localhost:8080/uploads/user/',
                    'user' => $user,
                    'form' => $form
                ]),
            ])
        );
    }

    /**
     * @return ResponseInterface
     */
    public function detailsAction(): ResponseInterface
    {
        $userDetails = [];
        $user = $this->authenticationService->getIdentity();
        if (!empty($user)) {
            $userDetails['detail']['firstName'] = $user->getDetail()->getFirstName();
            $userDetails['detail']['lastName'] = $user->getDetail()->getLastName();
        }
        $form = new ProfileDetailsForm();

        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if (RequestMethodInterface::METHOD_POST === $this->request->getMethod()) {
            $form->setData($this->request->getParsedBody());
            if ($form->isValid()) {
                $userData = $form->getData();
                try {
                    $this->userService->updateUser($user, $userData);
                } catch (\Exception $e) {
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($form);
                    $this->messenger->addError($e->getMessage(), 'profile-details');

                    return new RedirectResponse($this->request->getUri(), 303);
                }

                $this->messenger->addSuccess('Profile details updated.', 'profile-details');
                return new RedirectResponse($this->router->generateUri(
                    "account",
                    ['action' => 'details']
                ));
            } else {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($form);
                $this->messenger->addError($this->forms->getMessages($form), 'profile-details');

                return new RedirectResponse($this->request->getUri(), 303);
            }
        } else {
            $form->setData($userDetails);
        }

        return new HtmlResponse(
            $this->template->render('user::profile', [
                'action' => 'details',
                'content' => $this->template->render('profile::details', [
                    'form' => $form
                ]),
            ])
        );
    }

    /**
     * @return ResponseInterface
     */
    public function changePasswordAction(): ResponseInterface
    {
        $user = $this->authenticationService->getIdentity();

        $form = new ProfilePasswordForm();

        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if (RequestMethodInterface::METHOD_POST === $this->request->getMethod()) {
            $form->setData($this->request->getParsedBody());
            if ($form->isValid()) {
                $userData = $form->getData();
                try {
                    $this->userService->updateUser($user, $userData);
                } catch (\Exception $e) {
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($form);
                    $this->messenger->addError($e->getMessage(), 'profile-password');

                    return new RedirectResponse($this->request->getUri(), 303);
                }

                // logout and enter new password to login
                $this->authenticationService->clearIdentity();

                $this->messenger->addSuccess('Password updated. Login with your new credentials.', 'user-login');
                return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
            } else {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($form);
                $this->messenger->addError($this->forms->getMessages($form), 'profile-password');

                return new RedirectResponse($this->request->getUri(), 303);
            }
        }

        return new HtmlResponse(
            $this->template->render('user::profile', [
                'action' => 'change-password',
                'content' => $this->template->render('profile::change-password', [
                    'form' => $form
                ]),
            ])
        );
    }

    /**
     * @return ResponseInterface
     */
    public function deleteAccountAction(): ResponseInterface
    {
        $user = $this->authenticationService->getIdentity();

        $form = new ProfileDeleteForm();

        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if (RequestMethodInterface::METHOD_POST === $this->request->getMethod()) {
            $form->setData($this->request->getParsedBody());
            if ($form->isValid()) {
                $userData = $form->getData();
                try {
                    $this->userService->updateUser($user, $userData);
                } catch (\Exception $e) {
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($form);
                    $this->messenger->addError($e->getMessage(), 'profile-delete');

                    return new RedirectResponse($this->request->getUri(), 303);
                }

                // logout and enter new password to login
                $this->authenticationService->clearIdentity();

                $this->messenger->addSuccess('Your account is deleted.', 'page-home');
                return new RedirectResponse($this->router->generateUri("page"));
            } else {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($form);
                $this->messenger->addError($this->forms->getMessages($form), 'profile-delete');

                return new RedirectResponse($this->request->getUri(), 303);
            }
        }

        return new HtmlResponse(
            $this->template->render('user::profile', [
                'action' => 'delete-account',
                'content' => $this->template->render('profile::delete-account', [
                    'form' => $form
                ]),
            ])
        );
    }
}
