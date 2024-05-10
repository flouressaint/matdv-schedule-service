<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;

class AdminControllerTest extends AbstractControllerTest
{
    public function testGrantTeacher(): void
    {
        $user = $this->createUser('usernameTest', 'testtest');
        $this->createAdminAndAuth('admin', 'testtest');

        $this->client->jsonRequest('POST', '/api/v1/admin/grantTeacher/'.$user->getUsername());

        $this->assertResponseIsSuccessful();
    }

    public function testAuditoriums(): void
    {
        $this->em->persist(MockUtils::createAuditorium());
        $this->em->flush();

        $this->createAdminAndAuth('admin', 'testtest');
        $this->client->jsonRequest('GET', '/api/v1/admin/auditoriums');
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
        $this->client->jsonRequest('POST', '/api/v1/admin/auditorium', [
            'name' => 'kab 2',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testUpdateAuditorium(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $auditorium = MockUtils::createAuditorium();
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->jsonRequest('PUT', '/api/v1/admin/auditorium/'.$auditorium->getId(), [
            'name' => 'Math2',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteAuditorium(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');
        $auditorium = MockUtils::createAuditorium();
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->jsonRequest('DELETE', '/api/v1/admin/auditorium/'.$auditorium->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testStudyGroups(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);

        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('GET', '/api/v1/admin/studyGroups');

        $this->assertResponseIsSuccessful();
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
    }

    public function testGetStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);

        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('GET', '/api/v1/admin/studyGroup/'.$studyGroup->getId());

        $this->assertResponseIsSuccessful();
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
    }

    public function testCreateStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $this->em->persist($studyGroupCategory);
        $this->em->flush();

        $this->client->jsonRequest('POST', '/api/v1/admin/studyGroup', [
            'name' => 'Math 11class',
            'teacherId' => $teacher->getId(),
            'categoryId' => $studyGroupCategory->getId(),
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testEditStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $newTeacher = $this->createTeacher('newTeacher', 'testtest');

        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $newStudyGroupCategory = MockUtils::createStudyGroupCategory()->setName('Math2');
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($newStudyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('PATCH', '/api/v1/admin/studyGroup/'.$studyGroup->getId(), [
            'name' => 'kab 2',
            'teacherId' => $newTeacher->getId(),
            'categoryId' => $newStudyGroupCategory->getId(),
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteStudyGroup(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('DELETE', '/api/v1/admin/studyGroup/'.$studyGroup->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testEnrollStudent(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $user = $this->createUser('usernameTest', 'testtest');
        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('POST', '/api/v1/admin/studyGroup/'.$studyGroup->getId().'/enroll/'.$user->getUsername());

        $this->assertResponseIsSuccessful();
    }

    public function testCreateStudyGroupCategory(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $this->client->jsonRequest('POST', '/api/v1/admin/studyGroupCategory', [
            'name' => 'Math',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testEditStudyGroupCategory(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $this->em->persist($studyGroupCategory);
        $this->em->flush();

        $this->client->jsonRequest('PATCH', '/api/v1/admin/studyGroupCategory/'.$studyGroupCategory->getId(), [
            'name' => 'Math2',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteStudyGroupCategory(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $this->em->persist($studyGroupCategory);
        $this->em->flush();

        $this->client->jsonRequest('DELETE', '/api/v1/admin/studyGroupCategory/'.$studyGroupCategory->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testStudyGroupsByCategory(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();

        $this->client->jsonRequest('GET', '/api/v1/admin/studyGroupCategory/'.$studyGroupCategory->getId().'/studyGroups');

        $this->assertResponseIsSuccessful();
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
    }

    public function testLessons(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $auditorium = MockUtils::createAuditorium();
        $hometask = MockUtils::createHometask();
        $lesson = MockUtils::createLesson($auditorium, $studyGroup, $hometask);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->persist($auditorium);
        $this->em->persist($hometask);
        $this->em->persist($lesson);
        $this->em->flush();

        $this->client->jsonRequest('GET', '/api/v1/admin/lessons');

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'date', 'startTime', 'endTime', 'auditorium', 'studyGroup', 'hometask'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'date' => ['type' => 'string'],
                            'startTime' => ['type' => 'string'],
                            'endTime' => ['type' => 'string'],
                            'auditorium' => [
                                'type' => 'object',
                                'required' => ['id', 'name'],
                                'properties' => [
                                    'id' => ['type' => 'integer'],
                                    'name' => ['type' => 'string'],
                                ],
                            ],
                            'studyGroup' => [
                                'type' => 'object',
                                'required' => ['id', 'name', 'teacher'],
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
                                ],
                            ],
                            'hometask' => [
                                'type' => 'object',
                                'required' => ['id', 'description', 'attachment'],
                                'properties' => [
                                    'id' => ['type' => 'integer'],
                                    'description' => ['type' => 'string'],
                                    'attachment' => ['type' => 'string'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testGetLesson(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $auditorium = MockUtils::createAuditorium();
        $hometask = MockUtils::createHometask();
        $lesson = MockUtils::createLesson($auditorium, $studyGroup, $hometask);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->persist($auditorium);
        $this->em->persist($hometask);
        $this->em->persist($lesson);
        $this->em->flush();

        $this->client->jsonRequest('GET', '/api/v1/admin/lesson/'.$lesson->getId());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id', 'date', 'startTime', 'endTime', 'auditorium', 'studyGroup', 'hometask'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'date' => ['type' => 'string'],
                'startTime' => ['type' => 'string'],
                'endTime' => ['type' => 'string'],
                'auditorium' => [
                    'type' => 'object',
                    'required' => ['id', 'name'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'name' => ['type' => 'string'],
                    ],
                ],
                'studyGroup' => [
                    'type' => 'object',
                    'required' => ['id', 'name', 'teacher'],
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
                    ],
                ],
                'hometask' => [
                    'type' => 'object',
                    'required' => ['id', 'description', 'attachment'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'description' => ['type' => 'string'],
                        'attachment' => ['type' => 'string'],
                    ],
                ],
            ],
        ]);
    }

    public function testCreateLesson(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $auditorium = MockUtils::createAuditorium();
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $this->em->persist($auditorium);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->flush();
        $this->client->jsonRequest('POST', '/api/v1/admin/lesson', [
            'date' => '19.01.2022',
            'startTime' => '10:40',
            'endTime' => '11:40',
            'auditoriumId' => $auditorium->getId(),
            'studyGroupId' => $studyGroup->getId(),
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testDeleteLesson(): void
    {
        $this->createAdminAndAuth('admin', 'testtest');

        $teacher = $this->createTeacher('teacher', 'testtest');
        $auditorium = MockUtils::createAuditorium();
        $studyGroupCategory = MockUtils::createStudyGroupCategory();
        $studyGroup = MockUtils::createStudyGroup($teacher, $studyGroupCategory);
        $hometask = MockUtils::createHometask();
        $lesson = MockUtils::createLesson($auditorium, $studyGroup, $hometask);
        $this->em->persist($auditorium);
        $this->em->persist($studyGroupCategory);
        $this->em->persist($studyGroup);
        $this->em->persist($lesson);
        $this->em->flush();

        $this->client->jsonRequest('DELETE', '/api/v1/admin/lesson/'.$lesson->getId());

        $this->assertResponseIsSuccessful();
    }
}
