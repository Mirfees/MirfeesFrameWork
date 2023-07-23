<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity\ActiveRecordEntity;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\UsersAuthService;

class User extends ActiveRecordEntity
{
    protected $nickname;

    protected $email;

    protected $isConfirmed;

    protected $role;

    protected $passwordHash;

    protected $authToken;

    protected $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @param mixed $authToken
     */
    public function setAuthToken($authToken): void
    {
        $this->authToken = $authToken;
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @return mixed
     */
    public function isConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $isConfirmed
     */
    public function setIsConfirmed(int $isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }

    public function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public static function signUp(array $userData): User
    {
        extract($userData);

        if (empty($nickname)) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if(!preg_match('~^[a-zA-Z0-9]+$~', $nickname)) {
            throw new InvalidArgumentException('Nickname должен состоять только из символов латинского алфавита и цифр');
        }

        if (empty($email)) {
            throw new InvalidArgumentException('Не передан email');
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('email некорректен');
        }

        if (empty($password)) {
            throw new InvalidArgumentException('Не передан password');
        }

        if(!preg_match('~^[a-zA-Z0-9\s/!/@/#/$/%/^/&/*/(/)/-/_/+/=]+$~', $password)) {
            throw new InvalidArgumentException('Пароль должен содержать только латинские символы, специальные символы и цифры');
        }

        if(mb_strlen($password < 8)) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if (static::findOneByColumn('nickname', $nickname) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $email) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->nickname = $nickname;
        $user->email = $email;
        $user->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));

        $user->save();
        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginData): User
    {

        extract($loginData);

        if (empty($email)) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($password)) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = User::findOneByColumn('email', $email);
        if ($user === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }


        if (!password_verify($password, $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public static function logout(): void
    {
        setcookie('token', '', 0, '/', '', false, true);
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}