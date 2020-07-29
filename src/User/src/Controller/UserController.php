<?php

namespace Frontend\User\Controller;

use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Entity\User;
use Frontend\User\Form\UserForm;
use Frontend\User\FormData\UserFormData;
use Frontend\User\InputFilter\EditUserInputFilter;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserController
 * @package Frontend\User\Controller
 */
class UserController extends AbstractActionController
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

    /** @var UserForm $userForm */
    protected UserForm $userForm;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @param UserForm $userForm
     */
    public function __construct(
        UserService $userService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms,
        UserForm $userForm
    ) {
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->userForm = $userForm;
    }

    /**
     * @return HtmlResponse
     */
    public function manageAction()
    {
        return new HtmlResponse($this->template->render('user::list'));
    }

    /**
     * @return JsonResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function listAction()
    {
        $params = $this->getRequest()->getQueryParams();

        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? $params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? $params['limit'] : 30;

        $result = $this->userService->getUsers($offset, $limit, $search, $sort, $order);

        return new JsonResponse($result);
    }

    /**
     * @return ResponseInterface
     */
    public function addAction(): ResponseInterface
    {
        $request = $this->request;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->userForm->setData($data);
            if ($this->userForm->isValid()) {
                $result = $this->userForm->getData();
                try {
                    $this->userService->createUser($result);
                    return new JsonResponse(['success' => 'success', 'message' => 'User created successfully']);
                } catch (\Exception $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->userForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->userForm,
                    'formAction' => '/user/add'
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function editAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');

        $user = $this->userService->getUserRepository()->find($uuid);
        $formData = new UserFormData();
        $formData->fromEntity($user);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->userForm->setData($data);
            $this->userForm->setDifferentInputFilter(new EditUserInputFilter());
            if ($this->userForm->isValid()) {
                $result = $this->userForm->getData();
                try {
                    $this->userService->updateUser($user, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'User updated successfully']);
                } catch (\Exception $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->userForm)
                    ]
                );
            }
        }

        $this->userForm->bind($formData);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->userForm,
                    'formAction' => '/user/edit/' . $uuid
                ]
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $data = $request->getParsedBody();

        if (!empty($data['uuid'])) {
            $user = $this->userService->getUserRepository()->find($data['uuid']);
        } else {
            return new JsonResponse(['success' => 'error', 'message' => 'Could not find user']);
        }

        try {
            $user->setIsDeleted(User::IS_DELETED_YES);
            $user->setIdentity('anonymous' . date('dmYHis') . '@dotkernel.com');
            $userDetails = $user->getDetail();
            $userDetails->setFirstName('anonymous' . date('dmYHis'));
            $userDetails->setLastName('anonymous' . date('dmYHis'));
            $user->setDetail($userDetails);

            $this->userService->getUserRepository()->saveUser($user);
            return new JsonResponse(['success' => 'success', 'message' => 'User Deleted Successfully']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
