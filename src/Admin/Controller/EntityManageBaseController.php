<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 8:49 PM
 */

namespace Dot\Admin\Controller;

use Dot\Admin\Service\EntityServiceInterface;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessengerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Form\Form;
use Zend\Paginator\Paginator;

/**
 * Class EntityManageBaseController
 * @package Dot\Authentication\Controller
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
        return new RedirectResponse($this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'manage']));
    }

    /**
     * @return HtmlResponse
     */
    public function manageAction()
    {
        $listUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'list']);
        $addUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'add']);
        $editUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'edit']);
        $deleteUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'delete']);

        return new HtmlResponse(
            $this->template()->render(
                static::ENTITY_TEMPLATE_NAME,
                [
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
     * @return JsonResponse
     */
    public function listAction()
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();
        if (! isset($params['limit']) && ! isset($params['offset'])) {
            //send data without pagination
            return new JsonResponse($this->service->findAll([], $params, false));
        } else {
            $limit = isset($params['limit']) ? (int)$params['limit'] : 30;
            $offset = isset($params['offset']) ? (int)$params['offset'] : 0;

            /** @var Paginator $paginator */
            $paginator = $this->service->findAll([], $params, true);
            $paginator->setItemCountPerPage($limit);
            $paginator->setCurrentPageNumber(intval($offset / $limit) + 1);

            return new JsonResponse([
                'total' => $paginator->getTotalItemCount(),
                'rows' => (array)$paginator->getCurrentItems()
            ]);
        }
    }

    /**
     * @return HtmlResponse|JsonResponse
     */
    public function addAction()
    {
        $request = $this->request;
        /** @var Form $form */
        $form = $this->forms(static::ENTITY_FORM_NAME);
        $form->getBaseFieldset()->remove(static::ENTITY_ID_FIELD);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $form->setData($data);

            if ($form->isValid()) {
                $entity = $form->getData();
                try {
                    $id = $this->service->save($entity);
                    if ($id) {
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
                return $this->generateJsonOutput($this->getFormErrors($form->getMessages()), 'validation', $form);
            }
        }

        return new HtmlResponse(
            $this->template()->render(
                'partial::ajax-form',
                [
                    'form' => $form,
                    'formAction' =>
                        $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'add'])
                ]
            )
        );
    }

    /**
     * @return HtmlResponse|JsonResponse
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getAttribute('id');
        if (!$id) {
            return $this->generateJsonOutput($this->getEntityEditNoIdErrorMessage(), 'error');
        }

        $entity = $this->service->find([$this->service->getMapper()->getIdentifierName() => $id]);
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
                    $this->service->save($entity);
                    return $this->generateJsonOutput($this->getEntityUpdateSuccessMessage());
                } catch (\Exception $e) {
                    $message = $this->getEntityUpdateErrorMessage();
                    if ($this->isDebug()) {
                        $message = (array)$e->getMessage();
                    }
                    return $this->generateJsonOutput($message, 'error');
                }
            } else {
                return $this->generateJsonOutput($this->getFormErrors($form->getMessages()), 'validation', $form);
            }
        }

        return new HtmlResponse(
            $this->template()->render(
                'partial::ajax-form',
                [
                    'form' => $form,
                    'formAction' => $this->url()->generate(
                        static::ENTITY_ROUTE_NAME,
                        ['action' => 'edit', 'id' => $id]
                    )
                ]
            )
        );
    }

    /**
     * @return HtmlResponse|JsonResponse|RedirectResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        /** @var Form $form */
        $form = $this->forms(static::ENTITY_DELETE_FORM_NAME);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            if (isset($data[static::ENTITY_NAME_PLURAL]) && is_array($data[static::ENTITY_NAME_PLURAL])) {
                return new HtmlResponse(
                    $this->template()->render(
                        'partial::delete-form',
                        [
                            'form' => $form,
                            'deleteUri' => $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'delete']),
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
                                $result = $this->service->bulkDelete($ids);
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
                    return $this->generateJsonOutput($this->getFormErrors($form->getMessages()), 'validation', $form);
                }
            }
        }

        //redirect to manage page if trying to access this action via GET
        return new RedirectResponse($this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'manage']));
    }

    /**
     * @param array $messages
     * @param string $type
     * @param Form|null $form
     * @return JsonResponse
     */
    protected function generateJsonOutput(array $messages, $type = 'success', Form $form = null)
    {
        $dismissible = true;
        $typeToNamespace = [
            'success' => FlashMessengerInterface::SUCCESS_NAMESPACE,
            'error' => FlashMessengerInterface::ERROR_NAMESPACE,
            'info' => FlashMessengerInterface::INFO_NAMESPACE,
            'warning' => FlashMessengerInterface::WARNING_NAMESPACE,
            'validation' => FlashMessengerInterface::ERROR_NAMESPACE
        ];

        $alerts = $messages;
        if ($type === 'validation' && $form) {
            $alerts = $this->getFormMessages($form->getMessages());
            $dismissible = false;
        }

        $output = [$type => $messages];
        //render the alerts partial to send it through ajax to be inserted into the DOM
        $output['alerts'] = $this->template()->render(
            'dot-partial::alerts',
            ['dismissible' => $dismissible, 'messages' => [$typeToNamespace[$type] => $alerts]]
        );

        return new JsonResponse($output);
    }

    /**
     * @param array $formMessages
     * @return array
     */
    protected function getFormMessages(array $formMessages)
    {
        $messages = [];
        foreach ($formMessages as $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if (is_string($m)) {
                        $messages[] = $m;
                    } elseif (is_array($m)) {
                        $messages = array_merge($messages, $this->getFormMessages($m));
                    }
                }
            } elseif (is_string($message)) {
                $messages[] = $message;
            }
        }

        return $messages;
    }

    /**
     * @param array $formMessages
     * @return array
     */
    protected function getFormErrors(array $formMessages)
    {
        $errors = [];
        foreach ($formMessages as $key => $message) {
            if (is_array($message)) {
                if (!isset($errors[$key])) {
                    $errors[$key] = array();
                }

                foreach ($message as $k => $m) {
                    if (is_string($m)) {
                        $errors[$key][] = $m;
                    } elseif (is_array($m)) {
                        $errors[$key][$k] = $this->getFormErrors($m);
                    }
                }
            } elseif (is_string($message)) {
                $errors[] = $message;
            }
        }

        return $errors;
    }

    /**
     * @return array
     */
    protected function getEntityCreateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' was successfully created'];
    }

    /**
     * @return array
     */
    protected function getEntityCreateErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' could not be created due to a server error. Please try again'
        ];
    }

    /**
     * @return array
     */
    protected function getEntityEditNoIdErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' id parameter is missing'];
    }

    /**
     * @return array
     */
    protected function getEntityIdInvalidErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' id is invalid.'];
    }

    /**
     * @return array
     */
    protected function getEntityUpdateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' was successfully updated'];
    }

    /**
     * @return array
     */
    protected function getEntityUpdateErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' could not be updated due to a server error. Please try again'
        ];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' was successfully removed'];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteNoChangesMessage()
    {
        return ['Delete operation was canceled. No changes were made'];
    }

    /**
     * @return array
     */
    protected function getEntityDeleteErrorMessage()
    {
        return [
            ucfirst(static::ENTITY_NAME_SINGULAR) .
            ' could not be removed due to a server error. Please try again'
        ];
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }
}
