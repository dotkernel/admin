<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 8:49 PM
 */

namespace Dot\Admin\Controller;

use Dot\Controller\AbstractActionController;
use Dot\Ems\Service\EntityService;
use Dot\FlashMessenger\FlashMessengerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Form\Form;
use Zend\Paginator\Paginator;

/**
 * Class EntityManageBaseController
 * @package Dot\Admin\Controller
 */
class EntityManageBaseController extends AbstractActionController
{
    const ENTITY_NAME_SINGULAR = '';
    const ENTITY_NAME_PLURAL = '';
    const ENTITY_ROUTE_NAME = '';
    const ENTITY_TEMPLATE_NAME = '';

    /** @var  EntityService */
    protected $service;

    /** @var  Form */
    protected $entityForm;

    /** @var  Form */
    protected $deleteForm;

    /** @var  bool */
    protected $debug;

    /**
     * UserController constructor.
     * @param EntityService $service
     * @param Form $entityForm
     * @param Form $deleteForm
     */
    public function __construct(
        EntityService $service,
        Form $entityForm,
        Form $deleteForm)
    {
        $this->service = $service;
        $this->entityForm = $entityForm;
        $this->deleteForm = $deleteForm;
    }

    public function indexAction()
    {
        return new RedirectResponse($this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'manage']));
    }

    public function manageAction()
    {
        $listUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'list']);
        $addUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'add']);
        $editUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'edit']);
        $deleteUri = $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'delete']);

        return new HtmlResponse($this->template()->render(static::ENTITY_TEMPLATE_NAME,
            ['listUri' => $listUri, 'editUri' => $editUri, 'addUri' => $addUri,
                'deleteUri' => $deleteUri, 'entityNameSingular' => static::ENTITY_NAME_SINGULAR,
                'entityNamePlural' => static::ENTITY_NAME_PLURAL]));
    }

    public function listAction()
    {
        //get query params as sent by bootstrap-table
        $params = $this->request->getQueryParams();
        $limit = isset($params['limit']) ? (int)$params['limit'] : 30;
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;

        /** @var Paginator $paginator */
        $paginator = $this->service->findAll([], $params, true);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber(intval($offset/$limit));

        return new JsonResponse([
            'total' => $paginator->getTotalItemCount(),
            'rows' => (array) $paginator->getCurrentItems()]);
    }

    public function addAction()
    {
        $request = $this->request;
        $form = $this->entityForm;
        $form->getBaseFieldset()->remove('id');

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $form->bind($this->service->getMapper()->getPrototype());
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

                } catch(\Exception $e) {
                    $message = $this->getEntityCreateErrorMessage();
                    if($this->isDebug()) {
                        $message = (array) $e->getMessage();
                    }
                    return $this->generateJsonOutput($message, 'error');
                }
            } else {
                return $this->generateJsonOutput($form->getMessages(), 'validation', $form);
            }
        }

        return new HtmlResponse($this->template()->render('partial::ajax-form',
            ['form' => $form, 'formAction' => $this->url()->generate(static::ENTITY_ROUTE_NAME, ['action' => 'add'])]));
    }

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

        $form = $this->entityForm;
        $form->bind($entity);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $form->setData($data);

            if ($form->isValid()) {
                $entity = $form->getData();
                try {
                    $id = $this->service->save($entity);
                    if($id) {
                        return $this->generateJsonOutput($this->getEntityUpdateSuccessMessage());
                    }
                    else {
                        return $this->generateJsonOutput($this->getEntityUpdateErrorMessage());
                    }
                } catch (\Exception $e) {
                    $message = $this->getEntityUpdateErrorMessage();
                    if($this->isDebug()) {
                        $message = (array) $e->getMessage();
                    }
                    return $this->generateJsonOutput($message, 'error');
                }
            } else {
                return $this->generateJsonOutput($form->getMessages(), 'validation', $form);
            }
        }

        return new HtmlResponse($this->template()->render('partial::ajax-form',
            ['form' => $form, 'formAction' => $this->url()->generate(static::ENTITY_ROUTE_NAME,
                ['action' => 'edit', 'id' => $id])]));
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
        if($type === 'validation' && $form) {
            $alerts = $this->getFormMessages($form->getMessages());
            $dismissible = false;
        }

        $output = [$type => $messages];
        //render the alerts partial to send it through ajax to be inserted into the DOM
        $output['alerts'] = $this->template()->render('dot-partial::alerts',
            ['dismissible' => $dismissible, 'messages' => [$typeToNamespace[$type] => $alerts]]);
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
                        $messages = array_merge($messages, $this->getFormMessages($message));
                        break;
                    }
                }
            }
        }

        return $messages;
    }

    protected function getEntityCreateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' was successfully created'];
    }

    protected function getEntityCreateErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' could not be created due to a server error. Please try again'];
    }

    protected function getEntityEditNoIdErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' id parameter is missing'];
    }

    protected function getEntityIdInvalidErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' id is invalid.'];
    }

    protected function getEntityUpdateSuccessMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' was successfully updated'];
    }

    protected function getEntityUpdateErrorMessage()
    {
        return [ucfirst(static::ENTITY_NAME_SINGULAR) . ' could not be updated due to a server error. Please try again'];
    }
}