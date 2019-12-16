<?php
/**
 * @copyright Copyright (c) 2019 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TestingDirectEditing\DirectEditing;


use OCA\TestingDirectEditing\AppInfo\Application;
use OCP\DirectEditing\ACreateFromTemplate;
use OCP\Files\File;
use OCP\IL10N;

class TestingDirectEditingDocumentTemplateCreator extends ACreateFromTemplate {

	/**
	 * @var IL10N
	 */
	private $l10n;

	public function __construct(IL10N $l10n) {
		$this->l10n = $l10n;
	}

	public function getId(): string {
		return 'documenttemplate';
	}

	public function getName(): string {
		return $this->l10n->t('New text document from template');
	}

	public function getExtension(): string {
		return '.md';
	}

	public function getTemplates(): array {
		$urlGenerator = \OC::$server->getURLGenerator();
		return [
			'1' => [
				'id' => '1',
				'extension' => 'md',
				'name' => 'Weekly ToDo',
				'preview' => $urlGenerator->getAbsoluteURL($urlGenerator->imagePath(Application::APP_NAME, '1.jpg'))
			],
			'2' => [
				'id' => '2',
				'extension' => 'md',
				'name' => 'Meeting notes',
				'preview' => $urlGenerator->getAbsoluteURL($urlGenerator->imagePath(Application::APP_NAME, '2.jpg'))
			]
		];
	}

	public function getMimetype(): string {
		return 'text/markdown';
	}

	public function create(File $file, string $creatorId = null, string $templateId = null): void {
		$template = self::getTemplates()[$templateId];
		$file->putContent('## ' . $template['name'] . '\n\n' . 'Created from a template with Nextcloud text');
	}

}
