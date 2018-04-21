<?php declare(strict_types = 1);

namespace SilbinaryWolf\SilverstripePHPStan;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Type;
use PHPStan\Type\IterableType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\IterableTypeTrait;
use PHPStan\Type\NestedArrayItemType;
use PHPStan\Type\StaticResolvableType;

class DataListType extends ObjectType implements StaticResolvableType
{
    use IterableTypeTrait;

    public function __construct(string $dataListClassName, Type $itemType)
    {
        parent::__construct($dataListClassName);
        $this->itemType = $itemType;
    }

    public function describe(): string
    {
        $dataListTypeClass = count($this->getReferencedClasses()) === 1 ? $this->getReferencedClasses()[0] : '';
        $itemTypeClass = count($this->itemType->getReferencedClasses()) === 1 ? $this->itemType->getReferencedClasses()[0] : '';
        return sprintf('%s<%s>', $dataListTypeClass, $itemTypeClass);
    }

    public function getItemType(): Type
    {
        return $this->itemType;
    }

    public function getIterableValueType(): Type
    {
        return $this->itemType;
    }

    public function resolveStatic(string $className): Type
    {
        return $this;
    }

    public function changeBaseClass(string $className): StaticResolvableType
    {
        return $this;
    }

    public function isDocumentableNatively(): bool
    {
        return true;
    }

    // IterableTrait

    public function canCallMethods(): bool
    {
        return true;
    }

    public function hasMethod(string $methodName): bool
    {
        return parent::hasMethod($methodName);
    }

    public function getMethod(string $methodName, Scope $scope): MethodReflection
    {
        return parent::getMethod($methodName, $scope);
    }

    public function isClonable(): bool
    {
        return true;
    }

    public function canAccessProperties(): bool
    {
        return parent::canAccessProperties();
    }

    public function hasProperty(string $propertyName): bool
    {
        return parent::hasProperty($propertyName);
    }

    public function getProperty(string $propertyName, Scope $scope): PropertyReflection
    {
        return parent::getProperty($propertyName, $scope);
    }

    /*public function hasMethod(string $methodName): bool
    {
        $result = parent::hasMethod($methodName);
        if ($methodName === 'first') {
            //var_dump($methodName.(int)$result); exit;
        }
        return $result;
    }

    public function getMethod(string $methodName, Scope $scope): MethodReflection
    {
        $result = parent::getMethod($methodName, $scope);
        //var_dump($methodName);
        //var_dump($result); exit;
        return $result;
    }*/
}
