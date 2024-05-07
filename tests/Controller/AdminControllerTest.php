<?php

namespace App\Tests\Controller;

use App\Entity\Auditorium;
use App\Entity\StudyGroup;
use App\Entity\StudyGroupCategory;
use App\Tests\AbstractControllerTest;

class AdminControllerTest extends AbstractControllerTest
{
    public function testGrantTeacher(): void
    {
        $user = $this->createUser('usernameTest', 'testtest');

        $this->createAdminAndAuth('admin', 'testtest');
        $this->client->request('POST', '/api/v1/admin/grantTeacher/'.$user->getUsername());

        $this->assertResponseIsSuccessful();
    }

    public function testAuditoriums(): void
    {
        $this->em->persist((new Auditorium())->setName('kab 2'));
        $this->em->persist((new Auditorium())->setName('kab 3'));
        $this->em->flush();

        $this->createAdminAndAuth('admin', 'testtest');
        $this->client->request('GET', '/api/v1/admin/auditoriums');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name'],
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testCreateAuditorium(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $this->client->request('POST', '/api/v1/admin/auditorium', [
            'name' => 'kab 2',
        ]);

        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateAuditorium(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $auditorium = (new Auditorium())->setName('kab 1');
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->request('PUT', '/api/v1/admin/auditorium/'.$auditorium->getId(), [
            'name' => 'Math2',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteAuditorium(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $auditorium = (new Auditorium())->setName('kab 2');
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/admin/auditorium/'.$auditorium->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testStudyGroups(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = (new StudyGroupCategory())->setName('Math');
        $this->em->persist($studyGroupCategory);

        $studyGroup = (new StudyGroup())
            ->setName('Math 11class')
            ->setTeacher($teacher)
            ->setStudyGroupCategory($studyGroupCategory)
        ;
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/admin/studyGroups');
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name'],
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testGetStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = (new StudyGroupCategory())->setName('Math');
        $this->em->persist($studyGroupCategory);

        $studyGroup = (new StudyGroup())
            ->setName('Math 11class')
            ->setTeacher($teacher)
            ->setStudyGroupCategory($studyGroupCategory)
        ;
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/admin/studyGroup/'.$studyGroup->getId());
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id', 'name', 'teacher', 'students'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
                'teacher' => [
                    'type' => 'object',
                    'required' => ['id', 'name'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'name' => ['type' => 'string'],
                    ],
                ],
                'students' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $teacher = $this->createTeacher('teacher', 'testtest');

        $studyGroupCategory = (new StudyGroupCategory())->setName('Math');
        $this->em->persist($studyGroupCategory);
        $this->em->flush();

        $this->client->request('POST', '/api/v1/admin/studyGroup', [], [], [], json_encode([
            'name' => 'kab 2',
            'teacherId' => $teacher->getId(),
            'categoryId' => $studyGroupCategory->getId(),
        ]));

        // $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
        //     'type' => 'object',
        //     'required' => ['id'],
        //     'properties' => [
        //         'id' => ['type' => 'integer'],
        //     ],
        // ]);

        $this->assertResponseIsSuccessful();
    }

    public function testEditStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $newTeacher = $this->createTeacher('newTeacher', 'testtest');

        $studyGroupCategory = (new StudyGroupCategory())->setName('Math');
        $newStudyGroupCategory = (new StudyGroupCategory())->setName('Math2');
        $this->em->persist($studyGroupCategory);
        $this->em->persist($newStudyGroupCategory);

        $studyGroup = (new StudyGroup())
            ->setName('Math 11class')
            ->setTeacher($teacher)
            ->setStudyGroupCategory($studyGroupCategory)
        ;
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->request('PATCH', '/api/v1/admin/studyGroup/'.$studyGroup->getId(), [
            'name' => 'kab 2',
            'teacherId' => $newTeacher->getId(),
            'categoryId' => $newStudyGroupCategory->getId(),
        ]);

        $this->assertResponseIsSuccessful();
    }
}