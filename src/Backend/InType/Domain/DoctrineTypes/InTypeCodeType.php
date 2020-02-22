<?php

namespace Mateu\Backend\InType\Domain\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Mateu\Backend\InType\Domain\InTypeCode;

class InTypeCodeType extends Type
{
    const INTYPECODE = 'inTypeCode';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new InTypeCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration  The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return  "VARCHAR(50)";
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    public function getName()
    {
        return self::INTYPECODE;
    }

    public function canRequireSQLConversion()
    {
        return false;
    }
}