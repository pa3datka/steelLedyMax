<?php

namespace App\Models;

use App\DB\Connection;

class User
{
    /**
     * Name database connection
     */
    private const CONNECTION = 'db';

    /**
     * Table name
     */
    private const TABLE = 'users';

    private const TYPE_SEX_MALE = 1;

    private const TYPE_SEX_WOMAN = 0;

    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $firstname;

    /**
     * @var string
     */
    public string $lastname;

    /**
     * @var int
     */
    public int $sex;

    /**
     * @var int
     */
    public int $date_birth;

    /**
     * @var string
     */
    public string $motherland;


    /**
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $fields += [
            'id' => null,
            'firstname' => '',
            'lastname' => '',
            'sex' => null,
            'date_birth' => null,
            'motherland' => ''
        ];

        ($fields['id'] ?? null) && $this->id = (int)$fields['id'];
        $this->firstname = $fields['firstname'];
        $this->lastname = $fields['lastname'];
        $this->sex = (int)$fields['sex'];
        $this->date_birth = (int)$fields['date_birth'];
        $this->motherland = $fields['motherland'];
    }

    /**
     * Create new user
     *
     * @return int
     */
    public function create(): int
    {
        $connect = Connection::connect(self::CONNECTION);

        $fieldPrepare = [
            'firstname' => htmlspecialchars($this->firstname),
            'lastname' => htmlspecialchars($this->lastname),
            'date_birth' => $this->date_birth,
            'sex' => $this->sex,
            'motherland' => htmlspecialchars($this->motherland)
        ];
        $sql = 'INSERT INTO `' . self::TABLE . '` (firstname, lastname, date_birth, sex, motherland)
                    VALUES (:firstname, :lastname, :date_birth, :sex, :motherland)';
        $stmt = $connect->prepare($sql);
        $stmt->execute($fieldPrepare);

        $userId = $connect->lastInsertId();
        $stmt = null;
        $this->id = (int)$userId;

        return $this->id;
    }

    /**
     * Update user fields
     *
     * @return void
     */
    public function update(): void
    {
        $connect = Connection::connect(self::CONNECTION);

        $fieldPrepare = [
            'id' => $this->id,
            'firstname' => htmlspecialchars($this->firstname),
            'lastname' => htmlspecialchars($this->lastname),
            'date_birth' => $this->date_birth,
            'sex' => $this->sex,
            'motherland' => htmlspecialchars($this->motherland)
        ];

        $sql = 'UPDATE ' . self::TABLE . ' SET firstname=:firstname, lastname=:lastname, date_birth=:date_birth, sex=:sex, motherland=:motherland WHERE id=:id;';
        $stmt = $connect->prepare($sql);
        $stmt->execute($fieldPrepare);
        $stmt = null;
    }

    /**
     * Delete User by ID
     *
     * @return void
     */
    public function delete(): void
    {
        $connect = Connection::connect(self::CONNECTION);
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE `id`=:id';
        $stmt = $connect->prepare($sql);
        $stmt->execute(['id' => $this->id]);
        $stmt = null;
    }

    /**
     * Сonverts date of birth to age
     *
     * @return int
     */
    public function getAge(): ?int
    {
        if (!($this->date_birth ?? null)) {
            return null;
        }
        $toDate = date_create(date('Y-m-d', time()));
        $birthday = date_create(date('Y-m-d', $this->date_birth));
        return date_diff($birthday, $toDate)->y;
    }

    /**
     * Return human format type sex
     *
     * @return string
     */
    public function getSex(): string
    {
        switch (true) {
            case self::TYPE_SEX_MALE === $this->sex:
                $sex = 'male';
                break;
            case self::TYPE_SEX_WOMAN === $this->sex:
                $sex = 'woman';
                break;
            default:
                $sex = 'not determined';
            break;
        }

        return $sex;
    }


    /**
     *  for example
     *
     * @param User $user
     * @return string
     */
    public static function getHtml(User $user): string
    {
        $listHtml = '<table border="1">';
        $listHtml .= '<tr>';
        $listHtml .= '<th>ID</th>';
        $listHtml .= '<th>Name</th>';
        $listHtml .= '<th>Last Name</th>';
        $listHtml .= '<th>SEX</th>';
        $listHtml .= '<th>Age</th>';
        $listHtml .= '<th>Date birth</th>';
        $listHtml .= '<th>Motherland</th>';
        $listHtml .= '</tr>';
        $listHtml .= '<tr>';
        $listHtml .= '<td>' . ($user->id ?? '') . '</td>';
        $listHtml .= '<td>' . ($user->firstname ?? '') . '</td>';
        $listHtml .= '<td>' . ($user->lastname ?? '') . '</td>';
        $listHtml .= '<td>' . $user->getSex() . '</td>';
        $listHtml .= '<td>' . $user->getAge() . '</td>';
        $listHtml .= '<td>' . ($user->date_birth ? date('Y-m-d', $user->date_birth) : "") . '</td>';
        $listHtml .= '<td>' . ($user->motherland ?? '') . '</td>';
        $listHtml .= "</tr></table>";
        $listHtml .= '<br>';

        return $listHtml;
    }

}