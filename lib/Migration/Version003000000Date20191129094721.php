<?php
namespace OCA\Bookmarks\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;
use OCP\IDBConnection;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version003000000Date20191129094721 extends SimpleMigrationStep {
	private $db;

	public function __construct(IDBConnection $db) {
		$this->db = $db;
	}

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, \Closure $schemaClosure, array $options) {
	}

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 * @throws \Doctrine\DBAL\Schema\SchemaException
	 */
	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();
		if (!$schema->hasTable('bookmarks_folders_public')) {
			$table = $schema->createTable('bookmarks_folders_public');
			$table->addColumn('id', 'string', [
				'notnull' => true,
				'length' => 32,
			]);
			$table->addColumn('folder_id', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('description', 'string', [
				'notnull' => true,
				'length' => 4096,
				'default' => '',
			]);
			$table->addColumn('created_at', 'integer', [
				'notnull' => false,
				'length' => 4,
				'default' => 0,
				'unsigned' => true,
			]);
			$table->setPrimaryKey(['id'], 'bookmarks_public_id');
			$table->addIndex(['folder_id'], 'bookmarks_public_folder_id');
			$table->addIndex(['created_at'], 'bookmarks_public_created_at');
		}
		if (!$schema->hasTable('bookmarks_shares')) {
			$table = $schema->createTable('bookmarks_shares');
			$table->addColumn('id', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('folder_id', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('owner', 'string', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('participant', 'string', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('type', 'integer', [
				'notnull' => false,
				'length' => 4,
				'default' => 0,
				'unsigned' => true,
			]);
			$table->addColumn('created_at', 'integer', [
				'notnull' => false,
				'length' => 4,
				'default' => 0,
				'unsigned' => true,
			]);
			$table->addColumn('can_write', 'boolean', [
				'notnull' => true,
				'default' => false
			]);
			$table->addColumn('can_share', 'boolean', [
				'notnull' => true,
				'default' => false
			]);
			$table->setPrimaryKey(['id']);
			$table->addIndex(['created_at'], 'bookmarks_shared_created_at');
			$table->addIndex(['folder_id'], 'bookmarks_shared_folder_id');
			$table->addIndex(['owner'], 'bookmarks_shared_owner');
			$table->addIndex(['participant', 'type'], 'bookmarks_share_part');
		}

		if (!$schema->hasTable('bookmarks_shared')) {
			$table = $schema->createTable('bookmarks_shared');
			$table->addColumn('id', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('share_id', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true
			]);
			$table->addColumn('parent_folder', 'bigint', [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('index', 'bigint', [
				'notnull' => true,
				'length' => 10,
			]);
			$table->addIndex(['parent_folder'], 'bookmarks_part_parent');
			$table->addIndex(['user_id'], 'bookmarks_part');
			$table->addIndex(['parent_folder', 'index'], 'bookmarks_part_idx');
		}
		return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, \Closure $schemaClosure, array $options) {
	}
}
