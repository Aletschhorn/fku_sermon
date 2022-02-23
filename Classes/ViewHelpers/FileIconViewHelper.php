<?php
namespace FKU\FkuSermon\ViewHelpers;

/***************************************************************
*  Copyright notice
*
*  (c) 2016 Daniel Widmer <daniel.widmer@fku.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
*
* @package fku_sermon
*/

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Show Glyphicon depending on file type
 */
class FileIconViewHelper extends AbstractViewHelper {
	
	use CompileWithRenderStatic;

    public function initializeArguments() {
        $this->registerArgument('filetype', 'string', 'MIME file type expresseion', true);
	}

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$filetype = $renderChildrenClosure();
		if (! $filetype) {
			$filetype = $arguments['filetype'];
		}
		$filetypeShort = substr($filetype, 0, strpos($filetype, '/'));
		switch ((string)$filetypeShort) {
			case 'image':
				$icon = 'glyphicons-basic-38-picture';
				break;
			case 'audio':
				$icon = 'glyphicons-basic-77-headphones';
				break;
			case 'video':
				$icon = 'glyphicons-basic-9-film';
				break;
			default:
				switch ((string)$filetype) {
					case 'application/octet-stream':
						$icon = 'glyphicons-basic-77-headphones';
						break;
					default:
						$icon = 'glyphicons-basic-37-file';
						break;
				}
				break;
		}
		return $icon;
	}
}

?>