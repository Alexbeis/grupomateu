<?php

declare(strict_types=1);

namespace Mateu\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110150213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create races';
    }

    public function up(Schema $schema) : void
    {
        $date = (new \DateTime())->format('Y-m-d');

        $races = [
            ['code' => 'HR', 'name' => 'Hembra Rubia de Aquitania', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'M0000', 'name' => 'Macho C.Mestizo', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'HAS', 'name' => 'Hembra Asturiana', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'HL', 'name' => 'Hembra Limusina', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'ML', 'name' => 'Macho Limusina', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'M1117', 'name' => 'Macho Limusina', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'MA', 'name' => 'Macho Azul Belga', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'M1129', 'name' => 'Macho Pirenaica', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
            ['code' => 'MP', 'name' => 'Macho Parda', 'uuid' => Uuid::random()->getValue(), 'created_at' => $date, 'updated_at' => $date],
        ];

        foreach ($races as $race) {
            $this->addSql('INSERT INTO race VALUES(null, :uuid, :code, :name, :created_at, :updated_at)', $race);
        }
    }

    public function down(Schema $schema) : void
    {
        $this->throwIrreversibleMigrationException();
    }
}
