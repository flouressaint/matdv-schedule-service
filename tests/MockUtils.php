<?php

namespace App\Tests;

use App\Entity\Auditorium;
use App\Entity\Hometask;
use App\Entity\Lesson;
use App\Entity\StudyGroup;
use App\Entity\StudyGroupCategory;
use App\Entity\User;

class MockUtils
{
    public static function createAuditorium(): Auditorium
    {
        return (new Auditorium())
            ->setName('kabinet 1');
    }

    public static function createStudyGroupCategory(): StudyGroupCategory
    {
        return (new StudyGroupCategory())
            ->setName('Math');
    }

    public static function createStudyGroup(User $teacher, StudyGroupCategory $studyGroupCategory): StudyGroup
    {
        return (new StudyGroup())
            ->setName('Math 11class')
            ->setTeacher($teacher)
            ->setStudyGroupCategory($studyGroupCategory);
    }

    public static function createHometask(): Hometask
    {
        return (new Hometask())
            ->setDescription('hometask 1')
            ->setAttachment('attachment 1');
    }

    public static function createLesson(Auditorium $auditorium, StudyGroup $studyGroup, Hometask $hometask): Lesson
    {
        return (new Lesson())
            ->setDate(new \DateTimeImmutable('2022-01-01'))
            ->setStartTime(new \DateTimeImmutable('10:00'))
            ->setEndTime(new \DateTimeImmutable('11:00'))
            ->setAuditorium($auditorium)
            ->setStudyGroup($studyGroup)
            ->setHometask($hometask);
    }
}
