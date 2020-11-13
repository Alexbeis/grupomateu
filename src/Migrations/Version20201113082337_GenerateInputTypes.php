<?php

declare(strict_types=1);

namespace Mateu\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113082337_GenerateInputTypes extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Generate input types';
    }

    public function up(Schema $schema) : void
    {
        $date = (new \DateTime())->format('Y-m-d');

        $inputTypes = [
            ['code' => 'PRCH', 'name' => 'Compra', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'TRNSLD', 'name' => 'Translado', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'BRTH', 'name' => 'Nacimiento', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'OTHER', 'name' => 'Otro', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
        ];

        foreach ($inputTypes as $inputType) {
            $this->addSql('INSERT INTO in_type VALUES(null, :uuid, :code, :name, :created_at, :updated_at)', $inputType);
        }

    }

    public function down(Schema $schema) : void
    {
       $this->throwIrreversibleMigrationException();
    }
}
