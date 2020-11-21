<?php

declare(strict_types=1);

namespace Mateu\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121213417_AddGuideTotalAnimalsToIncomingRegister extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE incoming_register ADD total_animals_from_guide INTEGER NULL DEFAULT 0');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE incoming_register DROP total_animals_from_guide');

    }
}
