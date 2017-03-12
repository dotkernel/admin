<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Controller;

use Admin\App\Service\EntityServiceInterface;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessengerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Paginator\Paginator;
use Dot\Controller\Plugin\Authentication\AuthenticationPlugin;
use Dot\Controller\Plugin\Authorization\AuthorizationPlugin;
use Dot\Controller\Plugin\FlashMessenger\FlashMessengerPlugin;
use Dot\Controller\Plugin\Forms\FormsPlugin;
use Dot\Controller\Plugin\TemplatePlugin;
use Dot\Controller\Plugin\UrlHelperPlugin;
use Zend\Session\Container;
use Psr\Http\Message\UriInterface;
use Zend\Form\Form;

/**
 * Class EntityManageBaseController
 * @package Dot\Authentication\Controller
 *
 * @method UrlHelperPlugin|UriInterface url(string $route = null, array $params = [])
 * @method FlashMessengerPlugin messenger()
 * @method FormsPlugin|Form forms(string $name = null)
 * @method TemplatePlugin|string template(string $template = null, array $params = [])
 * @method AuthenticationPlugin authentication()
 * @method AuthorizationPlugin isGranted(string $permission, array $roles = [], mixed $context = null)
 * @method Container session(string $namespace)
 */
abstract class EntityManageBaseController extends AbstractActionController
{
    const ENTITY_NAME_SINGULAR = '';
    const ENTITY_NAME_PLURAL = '';
    const ENTITY_ROUTE_NAME = '';
    const ENTITY_TEMPLATE_NAME = '';

    const ENTITY_ID_FIELD = 'id';

    const ENTITY_FORM_NAME = '';
    const ENTITY_DELETE_FORM_NAME = '';

    const DEFAULT_SORTED_COLUMN = '';

    /** @var  EntityServiceInterface */
    protected $service;

    /** @var  bool */
    protected $debug;

    /**
     * UserController constructor.
     * @param EntityServiceInterface $service
     */
    public function __construct(EntityServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return new RedirectResponse($this->url(static::ENTITY_ROUTE_NAME, ['action' => 'manage']));
    }

    /**
     * @return HtmlResponse
     */
    public function manageAction()
    {
        $listUri = $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'list']);
        $addUri = $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'add']);
        $editUri = $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'edit']);
        $deleteUri = $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'delete']);

        return new HtmlResponse(
            $this->template(
                static::ENTITY_TEMPLATE_NAME,
                [
                    'defaultSortedColumn' => static::DEFAULT_SORTED_COLUMN,
                    'listUri' => $listUri,
                    'editUri' => $editUri,
                    'addUri' => $addUri,
                    'deleteUri' => $deleteUri,
                    'entityNameSingular' => static::ENTITY_NAME_SINGULAR,
                    'entityNamePlural' => static::ENTITY_NAME_PLURAL
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();

        $options = [];
        $sort = $params['sort'] ?? '';
        $order = $params['order'] ?? 'asc';

        $search = $params['search'] ?? '';
        $search = trim($search);

        if (!empty($sort) && !empty($order)) {
            $options['order'] = [$sort => $order];
        }

        if (!empty($search)) {
            $options['search'] = $search;
        }

        $limit = (int) $params['limit'] ?? 30;
        $offset = (int) $params['offset'] ?? 0;

        /** @var Paginator $paginator */
        $paginator = $this->service->findAll($options, true);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber(intval($offset / $limit) + 1);


        return new JsonResponse([
            'total' => $paginator->getTotalItemCount(),
            'rows' => (array)$paginator->getCurrentItems()
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function addAction(): ResponseInterface
    {
        $request = $this->request;
        /** @var Form $form */
        $form = $this->forms(static::ENTITY_FORM_NAME);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $form->setData($data);
            if ($form->isValid()) {
                $entity = $form->getData();
                try {
                    $entity = $this->service->save($entity);
                    if ($entity) {
                        return $this->generateJsonOutput($this->getEntityCreateSuccessMessage());
                    } else {
                        return $this->generateJsonOutput($this->getEntityCreateErrorMessage(), 'error');
                    }
                } catch (\Exception $e) {
                    $message = $this->getEntityCreateErrorMessage();
                    if ($this->isDebug()) {
                        $message = (array)$e->getMessage();
                    }
                    return $this->generateJsonOutput($message, 'error');
                }
            } else {
                return $this->generateJsonOutput($this->forms()->getErrors($form), 'validation', $form);
            }
        }

        return new HtmlResponse(
            $this->template(
                'partial::ajax-form',
                [
                    'form' => $form,
                    'formAction' =>
                        $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'add'])
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
        $id = $request->getAttribute('id');
        if (!$id) {
            return $this->generateJsonOutput($this->getEntityEditNoIdErrorMessage(), 'error');
        }

        $entity = $this->service->find($id);
        if (!$entity) {
            return $this->generateJsonOutput($this->getEntityIdInvalidErrorMessage(), 'error');
        }

        /** @var Form $form */
        $form = $this->forms(static::ENTITY_FORM_NAME);
        $form->bind($entity);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            //customize form validation callback
            if (method_exists($this, 'customizeEditValidation')) {
                call_user_func([$this, 'customizeEditValidation'], $form, $entity, $data);
            }

            $form->setData($data);

            if ($form->isValid()) {
                $entity = $form->getData();
                try {
                    $r = $this->service->save($entity);
                    if ($r) {
                        return $this->generateJsonOutput($this->getEntityUpdateSuccessMessage());
                    } else {
                        return $this->generateJsonOutput($this->getEntityUpdateErrorMessage(), 'error');
                    }
                } catch (\Exception $e) {
                    $message = $this->getEntityUpdateErrorMessage();
                    if ($this->isDebug()) {
                        $message = (array)$e->getMessage();
                    }
                    return $this->generateJsonOutput($message, 'error');
                }
            } else {
                return $this->generateJsonOutput($this->forms()->getErrors($form), 'validation', $form);
            }
        }

        return new HtmlResponse(
            $this->template(
                'partial::ajax-form',
                [
                    'form' => $form,
                    'formAction' => $this->url(
                        static::ENTITY_ROUTE_NAME,
                        ['action' => 'edit', 'id' => $id]
                    )
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function deleteAction(): ResponseInterface
    {
        $request = $this->getRequest();
        /** @var Form $form */
        $form = $this->forms(static::ENTITY_DELETE_FORM_NAME);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            if (isset($data[static::ENTITY_NAME_PLURAL]) && is_array($data[static::ENTITY_NAME_PLURAL])) {
                return new HtmlResponse(
                    $this->template()->render(
                        'partial::confirm-delete',
                        [
                            'form' => $form,
                            'deleteUri' => $this->url(static::ENTITY_ROUTE_NAME, ['action' => 'delete']),
                            'entities' => $data[static::ENTITY_NAME_PLURAL]
                        ]
                    )
                );
            } else {
                //used to validate CSRF token
                $form->setData($data);

                if ($form->isValid()) {
                    $ids = isset($data['ids']) && is_array($data['ids']) ? $data['ids'] : [];
                    $confirm = isset($data['confirm']) ? $data['confirm'] : 'no';
                    $markAsDeleted = isset($data['markAsDeleted']) ? $data['markAsDeleted'] : 'yes';

                    if (!empty($ids) && $confirm === 'yes') {
                        $markAsDeleted = $markAsDeleted === 'no' ? false : true;

                        try {
                            if ($markAsDeleted) {
                                $result = $this->service->markAsDeleted($ids);
                            } else {
                                $result = $this->service->deleteAll($ids);
                            }

                            if ($result) {
                                return $this->generateJsonOutput($this->getEntityDeleteSuccessMessage());
                            } else {
                                return $this->generateJsonOutput($this->getEntityDeleteNoChangesMessage(), 'info');
                            }
                        } catch (\Exception $e) {
                            $message = $this->getEntityDeleteErrorMessage();
                            if ($this->isDebug()) {
                                $message = (array)$e->getMessage();
                            }
                            return $this->generateJsonOutput($message, 'error');
                        }
                    } else {
                        //do nothing
                        return $this->generateJsonOutput($this->getEntityDeleteNoChangesMessage(), 'info');
                    }
                } else {
                    return $this->generateJsonOutput($this->forms()->getErrors($form), 'validation', $form);
                }
            }
        }

        //redirect to manage page if trying to access this action via GET
        return new RedirectResponse($this->url(static::ENTITY_ROUTE_NAME, ['action' => 'manage']));
    }

    /**
     * @param array $messages
     * @param string $type
     * @param Form|null $form
     * @return JsonResponse
     */
    protected function generateJsonOutput(array $messages, $type = 'success', Form $form = null): JsonResponse
    {
        $dismissible = true;
        $typeToNamespace = [
            'success' => FlashMessengerInterface::SUCCESS,
            'error' => FlashMessengerInterface::ERROR,
            'info' => FlashMessengerInterface::INFO,
            'warning' => FlashMessengerInterface::WARNING,
            'validation' => FlashMessengerInterface::ERROR
        ];

        $alerts = $messages;
        if ($type === 'validation' && $form) {
            $alerts = $this->forms()->getMessages($form);
            $dismissible = false;
        }

        $output = [$type => $messages];
        //render the alerts partial to send it through ajax to be inserted into the DOM
        $output['alerts'] = $this->template(
            'partial::alerts',
            ['dismissible' => $dismissible, 'messages' => [$typeToNamespace[$type] => $alerts]]
        );

        return new JsonResponse($output);
    }

    /**
     * @return array
     */
    protected function getEntityCreateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' entity was successfully created'];
    }

    /**
     * @return array
     */
    protected function getEntityCreateErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' entity could not be created due to a server error. Please try again'
        ];
    }

    /**
     * @return array
     */
    protected function getEntityEditNoIdErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' entity id parameter is missing'];
    }

    /**
     * @return array
     */
    protected function getEntityIdInvalidErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' entity id is invalid.'];
    }

    /**
     * @return array
     */
    protected function getEntityUpdateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' entity was successfully updated'];
    }

    /**
     * @return array
     */
    protected function getEntityUpdateErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' entity could not be updated due to a server error. Please try again'
        ];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' entity was successfully removed'];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteNoChangesMessage()
    {
        return ['Deletion not confirmed or no changes were made'];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' entity could not be removed due to a server error. Please try again'
        ];
    }
}
