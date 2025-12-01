<?php

declare(strict_types=1);

namespace Admin\User\Service;

use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Admin\User\InputFilter\CreateUserInputFilter;
use Core\App\Helper\Paginator;
use Core\App\Message;
use Core\Security\Repository\OAuthAccessTokenRepository;
use Core\Security\Repository\OAuthRefreshTokenRepository;
use Core\User\Entity\User;
use Core\User\Entity\UserDetail;
use Core\User\Entity\UserRole;
use Core\User\Enum\UserStatusEnum;
use Core\User\Repository\UserDetailRepository;
use Core\User\Repository\UserRepository;
use Core\User\Repository\UserRoleRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Dot\DependencyInjection\Attribute\Inject;
use Ramsey\Uuid\UuidInterface;

use function array_key_exists;
use function assert;
use function count;
use function date;
use function in_array;
use function is_array;

/**
 * @phpstan-import-type CreateUserDataType from CreateUserInputFilter
 */
class UserService implements UserServiceInterface
{
    /**
     * @param array<non-empty-string, mixed> $config
     */
    #[Inject(
        OAuthAccessTokenRepository::class,
        OAuthRefreshTokenRepository::class,
        UserRepository::class,
        UserDetailRepository::class,
        UserRoleRepository::class,
        'config',
    )]
    public function __construct(
        protected OAuthAccessTokenRepository $oAuthAccessTokenRepository,
        protected OAuthRefreshTokenRepository $oAuthRefreshTokenRepository,
        protected UserRepository $userRepository,
        protected UserDetailRepository $userDetailRepository,
        protected UserRoleRepository $userRoleRepository,
        protected array $config = [],
    ) {
    }

    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    public function deleteUser(User $user): User
    {
        $this->revokeTokens($user);

        return $this->anonymizeUser($user);
    }

    /**
     * @throws NotFoundException
     */
    public function findUser(string $id): User
    {
        $user = $this->userRepository->find($id);
        if (! $user instanceof User || $user->isDeleted()) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function findByEmail(string $email): User
    {
        $userDetail = $this->userDetailRepository->findOneBy(['email' => $email]);
        if (! $userDetail instanceof UserDetail) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }

        $user = $userDetail->getUser();
        if (! $user instanceof User) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }
        if ($user->isDeleted()) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function findByIdentity(string $identity): User
    {
        return $this->findOneBy(['identity' => $identity]);
    }

    /**
     * @param non-empty-array<non-empty-string, mixed> $params
     * @throws NotFoundException
     */
    public function findOneBy(array $params): User
    {
        $user = $this->userRepository->findOneBy($params);
        if (! $user instanceof User || $user->isDeleted()) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @param array<non-empty-string, mixed> $params
     * @return array<non-empty-string, mixed>
     */
    public function getUsers(array $params): array
    {
        $filters = $params['filters'] ?? [];
        $params  = Paginator::getParams($params, 'user.created');

        $sortableColumns = [
            'user.identity',
            'user.status',
            'user.created',
            'user.updated',
            'detail.firstName',
            'detail.lastName',
            'detail.email',
            'role.name',
        ];
        if (! in_array($params['sort'], $sortableColumns, true)) {
            $params['sort'] = 'user.created';
        }

        $paginator = new DoctrinePaginator($this->userRepository->getUsers($params, $filters)->getQuery());

        return Paginator::wrapper($paginator, $params, $filters);
    }

    /**
     * @phpstan-param CreateUserDataType $data
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function saveUser(array $data, ?User $user = null): User
    {
        if (! $user instanceof User) {
            $user = new User();
        }

        if (array_key_exists('identity', $data) && $data['identity'] !== null && ! $user->hasIdentity()) {
            $user->setIdentity($data['identity']);
        }
        if (array_key_exists('password', $data) && $data['password'] !== null && $data['password'] !== '') {
            $user->usePassword($data['password']);
        }
        if (array_key_exists('hash', $data) && $data['hash'] !== null) {
            $user->setHash($data['hash']);
        }
        if (array_key_exists('status', $data) && $data['status'] !== null) {
            $status = $data['status'];
            if (! $status instanceof UserStatusEnum) {
                $status = UserStatusEnum::tryFrom($status);
            }
            if (! $status instanceof UserStatusEnum) {
                throw new BadRequestException(Message::invalidValue('status'));
            }
            $user->setStatus($status);
        }
        if (array_key_exists('detail', $data) && is_array($data['detail'])) {
            if (! $user->hasDetail()) {
                $user->setDetail((new UserDetail())->setUser($user));
            }
            assert($user->getDetail() instanceof UserDetail);
            if (array_key_exists('firstName', $data['detail']) && $data['detail']['firstName'] !== null) {
                $user->getDetail()->setFirstname($data['detail']['firstName']);
            }
            if (array_key_exists('lastName', $data['detail']) && $data['detail']['lastName'] !== null) {
                $user->getDetail()->setLastName($data['detail']['lastName']);
            }
            if (array_key_exists('email', $data['detail']) && $data['detail']['email'] !== null) {
                $user->getDetail()->setEmail($data['detail']['email']);
            }
        }

        $this->validateUniqueUser((string) $user->getIdentity(), $user->getEmail(), $user->getId());

        if (array_key_exists('roles', $data) && count($data['roles']) > 0) {
            $user->resetRoles();
            foreach ($data['roles'] as $roleUuid) {
                $userRole = $this->userRoleRepository->find($roleUuid);
                if (! $userRole instanceof UserRole) {
                    throw new NotFoundException(Message::ROLE_NOT_FOUND);
                }
                $user->addRole($userRole);
            }
        }

        if (! $user->hasRoles()) {
            throw new BadRequestException(Message::RESTRICTION_ROLES);
        }

        $this->userRepository->saveResource($user);

        return $user;
    }

    private function anonymizeUser(User $user): User
    {
        $placeholder = $this->getAnonymousPlaceholder();

        $user
            ->setStatus(UserStatusEnum::Deleted)
            ->setIdentity($placeholder . $this->config['userAnonymizeAppend']);
        if ($user->hasDetail()) {
            assert($user->getDetail() instanceof UserDetail);
            $user
                ->getDetail()
                ->setFirstName($placeholder)
                ->setLastName($placeholder)
                ->setEmail($placeholder);
        }

        $this->userRepository->saveResource($user);

        return $user;
    }

    /**
     * @return non-empty-string
     */
    private function getAnonymousPlaceholder(): string
    {
        return 'anonymous' . date('dmYHis');
    }

    private function revokeTokens(User $user): void
    {
        $accessTokens = $this->oAuthAccessTokenRepository->findAccessTokens((string) $user->getIdentity());
        foreach ($accessTokens as $accessToken) {
            $this->oAuthAccessTokenRepository->revokeAccessToken($accessToken->getToken());
            $this->oAuthRefreshTokenRepository->revokeRefreshToken($accessToken->getToken());
        }
    }

    /**
     * @throws ConflictException
     */
    private function validateUniqueUser(string $identity, string $email, ?UuidInterface $id = null): void
    {
        $user = $this->userRepository->findOneBy(['identity' => $identity]);
        if ($user instanceof User) {
            if ($id === null) {
                throw new ConflictException(Message::DUPLICATE_IDENTITY);
            }
            if (! $user->getId()->equals($id)) {
                throw new ConflictException(Message::DUPLICATE_IDENTITY);
            }
        }

        $userDetail = $this->userDetailRepository->findOneBy(['email' => $email]);
        if ($userDetail instanceof UserDetail) {
            if ($id === null) {
                throw new ConflictException(Message::DUPLICATE_EMAIL);
            }
            assert($userDetail->getUser() instanceof User);
            if (! $userDetail->getUser()->getId()->equals($id)) {
                throw new ConflictException(Message::DUPLICATE_EMAIL);
            }
        }
    }
}
