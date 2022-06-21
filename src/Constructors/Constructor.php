<?php


namespace Arrilot\BitrixMigrations\Constructors;


class Constructor
{
    const OBJ_USER = 'USER'; // for the user
    const OBJ_BLOG_BLOG = 'BLOG_BLOG'; // for blog
    const OBJ_BLOG_POST = 'BLOG_POST'; // for blog post
    const OBJ_BLOG_COMMENT = 'BLOG_COMMENT'; // for comment on a post
    const OBJ_TASKS_TASK = 'TASKS_TASK'; // for tasks
    const OBJ_CALENDAR_EVENT = 'CALENDAR_EVENT'; // for calendar events
    const OBJ_LEARN_ATTEMPT = 'LEARN_ATTEMPT'; // for test attempts
    const OBJ_SONET_GROUP = 'SONET_GROUP'; // for sonet group
    const OBJ_WEBDAV = 'WEBDAV'; // for document libraries
    const OBJ_FORUM_MESSAGE = 'FORUM_MESSAGE'; // for forum message

    /**
     * for highload-block with ID=N
     * @param $id
     * @return string
     */
    public static function objHLBlock($id)
    {
        return "HLBLOCK_{$id}";
    }

    /**
     * for iblock sections with ID = N
     * @param $id
     * @return string
     */
    public static function objIBlockSection($id)
    {
        return "IBLOCK_{$id}_SECTION";
    }

    /**
     * For iblock with ID = N
     * @param $id
     * @return string
     */
    public static function objIBlock($id)
    {
        return "IBLOCK_{$id}";
    }
}