<?php

namespace App\Modules\Approval\Infrastructure\Factories;

use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;
use LogicException;

class ApprovalRepositoryFactory
{
    public static function getRepository(string $entityName): ApprovalRepositoryInterface
    {
        if (preg_match('/^(.*)\\\[^\\\]+\\\[^\\\]+$/', $entityName, $matches)) {
            $mainNamespace = $matches[1];
        } else {
            throw new LogicException('Invalid entity name: "' . $entityName . '".');
        }

        $namespaceParts = explode('\\', $mainNamespace);
        $moduleName = $namespaceParts[2];

        $repository = sprintf('App\\Modules\\%s\\Infrastructure\\Repositories\\%sRepository', $moduleName, $moduleName);
        if (!class_exists($repository)) {
            throw new LogicException('Class "' . $repository . '" does not exist.');
        }

        if (!in_array(ApprovalRepositoryInterface::class, class_implements($repository))) {
            throw new LogicException('Class "' . $repository . '" does not implement "' . ApprovalRepositoryInterface::class . '".');
        }

        return new $repository();
    }
}
