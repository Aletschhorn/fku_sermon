<?php
declare(strict_types = 1);

return [
    \FKU\FkuSermon\Domain\Model\FileReference::class => [
        'tableName' => 'sys_file_reference',
        'properties' => [
            'uid_local.mapOnProperty' => [
                'fieldName' => 'originalFileIdentifier',
            ],
        ],
    ],
];