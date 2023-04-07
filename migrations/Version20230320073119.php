<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320073119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE category_order category_order INT NOT NULL');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F022A24CF05 FOREIGN KEY (coupon_type_id) REFERENCES coupon_type (id)');
        $this->addSql('ALTER TABLE coupon RENAME INDEX uniq_f564111877153098 TO UNIQ_64BF3F0277153098');
        $this->addSql('ALTER TABLE coupon RENAME INDEX idx_f56411183ddd47b7 TO IDX_64BF3F022A24CF05');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939866C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_e52ffdee6d72b15c TO IDX_F529939866C5951B');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_e52ffdee67b3b43d TO IDX_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_835379F16C8A81A9 ON order_detail');
        $this->addSql('ALTER TABLE order_detail CHANGE product_id campaign_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46F639F774 ON order_detail (campaign_id)');
        $this->addSql('ALTER TABLE order_detail RENAME INDEX idx_835379f1cffe9ad6 TO IDX_ED896F468D9F6D38');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE category_order category_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F022A24CF05');
        $this->addSql('ALTER TABLE coupon RENAME INDEX idx_64bf3f022a24cf05 TO IDX_F56411183DDD47B7');
        $this->addSql('ALTER TABLE coupon RENAME INDEX uniq_64bf3f0277153098 TO UNIQ_F564111877153098');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939866C5951B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f529939866c5951b TO IDX_E52FFDEE6D72B15C');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f5299398a76ed395 TO IDX_E52FFDEE67B3B43D');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46F639F774');
        $this->addSql('DROP INDEX IDX_ED896F46F639F774 ON order_detail');
        $this->addSql('ALTER TABLE order_detail CHANGE campaign_id product_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_835379F16C8A81A9 ON order_detail (product_id)');
        $this->addSql('ALTER TABLE order_detail RENAME INDEX idx_ed896f468d9f6d38 TO IDX_835379F1CFFE9AD6');
    }
}
