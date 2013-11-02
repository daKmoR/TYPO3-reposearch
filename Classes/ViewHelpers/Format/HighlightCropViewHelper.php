<?php
namespace TYPO3\Reposearch\ViewHelpers\Format;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 */

/**
 * Use this view helper to crop and highlight the text between its opening and closing tags. See also
 * Examples from Tx_Fluid_ViewHelpers_Format_CropViewHelper
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:format.crop maxCharacters="10" highlightString="is">This is some very long text</f:format.crop>
 * </code>
 * <output>
 * This <strong>is</strong>...
 * </output>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class HighlightCropViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Format\CropViewHelper {

	/**
	 * Renders the cropped text and highlights the given value
	 *
	 * @param string $highlightString The String to highlight and center within the text
	 * @param integer $maxCharacters Place where to truncate the string
	 * @param string $stringToHighlightTruncate The String where to highlight and center the $highlightString
	 * @param string $append What to append, if truncation happened
	 * @param bool $respectWordBoundaries
	 * @param boolean $respectHtml If TRUE the cropped string will respect HTML tags and entities. Technically that means, that cropHTML() is called rather than crop()
	 * @internal param bool $respectBoundaries If TRUE and division is in the middle of a word, the remains of that word is removed.
	 * @return string cropped text
	 * @author Thomas Allmer <d4kmor@gmail.com>
	 */
	public function render($highlightString, $maxCharacters, $stringToHighlightTruncate = NULL, $append = '...', $respectWordBoundaries = TRUE, $respectHtml = TRUE) {
		if ($stringToHighlightTruncate === NULL) {
			$stringToHighlightTruncate = $this->renderChildren();
		}

		$startPoint = stripos($stringToHighlightTruncate, $highlightString);

		// try searching for standardized version of the highlightstring
		if ($startPoint === false) {
			$highlightString = strtr(utf8_decode($highlightString), utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'), 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
			$startPoint = stripos($stringToHighlightTruncate, $highlightString);
		}

		if ($startPoint !== false) {
			$before = ($maxCharacters - strlen($highlightString))/2;
			$before = (int) round($before, 0);

			$startPoint -= $before;
			$startPoint = $startPoint > 0 ? $startPoint : 0;
			$stringToHighlightTruncate = utf8_encode(substr(utf8_decode($stringToHighlightTruncate), $startPoint));
			$stringToHighlightTruncate = $startPoint > 0 ? '...' . $stringToHighlightTruncate : $stringToHighlightTruncate;

			$stringToHighlightTruncate = preg_replace('/(' . $highlightString . ')/i', '<strong>${1}</strong>', $stringToHighlightTruncate);
		}

		$stringToTruncate = $stringToHighlightTruncate;

		// below is a copy of the render function of crop
		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}

		if ($respectHtml) {
			$content = $this->contentObject->cropHTML($stringToTruncate, $maxCharacters . '|' . $append . '|' . $respectWordBoundaries);
		} else {
			$content = $this->contentObject->crop($stringToTruncate, $maxCharacters . '|' . $append . '|' . $respectWordBoundaries);
		}

		if (TYPO3_MODE === 'BE') {
			$this->resetFrontendEnvironment();
		}
		return $content;
	}

}