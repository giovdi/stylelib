<?php
namespace DeployStudio\Style\Minimalart;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class BoxStat extends \DeployStudio\Style\Base\BoxStat {
	/**
	 * Crea un nuovo box di statistiche
	 *
	 * @param int $variante variante del box da visualizzare (1, 2, 3, 4, 5)
	 * @param string $bg background
	 * @param string $icona icona da mostrare
	 * @param string $titolo titolo del box mostrato sotto il valore
	 * @param string $valore valore del box da mostrare
	 * @param string $ext opzionale, estensione (es. Gb) da mostrare affianco al valore, in piccolo
	 * @param string $link opzionale, compare il testo "Maggiori dettagli" con il link indicato (solo varianti 1, 4, 5)
	 * @param string $testo_link opzionale, puo' essere anche null se $link non e' definito, 'Maggiori dettagli' default
	 * @param string $boxclass opzionale, col-12 default
	 * @return void
	 */
	static function stat ($variante, $bg, $icona, $titolo, $valore, $ext = null, $boxclass = 'col-12',
		$link = null, $testo_link = 'Maggiori dettagli') {
		switch ($variante) {
			case 1:
				$content = '<!-- START card-->
				<div class="card bg-'.$bg.' border-0">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-3">
								<em class="'.$icona.' fa-5x"></em>
							</div>
							<div class="col-9 text-right">
								<div class="text-lg">'.$valore.'
									'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'
								</div>
								<p class="m-0">'.$titolo.'</p>
							</div>
						</div>
					</div>'
					.(!is_null($link) ? '
					<a class="card-footer bg-gray-dark bt0 clearfix btn-block d-flex" href="'.$link.'">
						<span>'.$testo_link.'</span>
						<span class="ml-auto">
							<em class="fa fa-chevron-circle-right"></em>
						</span>
					</a>' : '')
					.'
				</div>
				<!-- END card-->';
				break;

			case 2:
				$content = '<!-- START card-->
				<div class="card flex-row align-items-center align-items-stretch border-0">
					<div class="col-4 d-flex align-items-center bg-'.$bg.'-dark justify-content-center rounded-left">
						<em class="'.$icona.' fa-3x"></em>
					</div>
					<div class="col-8 py-3 bg-'.$bg.' rounded-right">
						<div class="h2 mt-0">'.$valore.'
							'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'
						</div>
						<div class="text-uppercase">'.$titolo.'</div>
					</div>
				</div>
				<!-- END card-->';
				break;

			case 3:
				$content = '<!-- START card-->
				<div class="card flex-row align-items-center align-items-stretch border-0">
					<div class="col-4 d-flex align-items-center bg-'.$bg.' justify-content-center rounded-left">
						<em class="'.$icona.' fa-3x"></em>
					</div>
					<div class="col-8 py-3 text-'.$bg.' rounded-right">
						<div class="h2 mt-0">'.$valore.'
							'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'
						</div>
						<div class="text-uppercase">'.$titolo.'</div>
					</div>
				</div>
				<!-- END card-->';
				break;

			case 4:
				$content = '<!-- START card-->
				<div class="card bg-'.$bg.'-dark border-0">
					<div class="row align-items-center mx-0">
						<div class="col-4 text-center">
							<em class="'.$icona.' fa-3x"></em>
						</div>
						<div class="col-8 py-4 bg-'.$bg.' rounded-right">
							<div class="h1 m-0 text-bold">'.$valore.'
								'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'
							</div>
							<div class="text-uppercase">'.$titolo.'</div>
						</div>
					</div>'
					.(!is_null($link) ? '
					<a class="card-footer bg-gray-dark bt0 clearfix btn-block d-flex" href="'.$link.'">
						<span>'.$testo_link.'</span>
						<span class="ml-auto">
							<em class="fa fa-chevron-circle-right"></em>
						</span>
					</a>' : '')
					.'
				</div>
				<!-- END card-->';
				break;

			case 5:
				$content = '<!-- START card-->
				<div class="card border-0">
					<div class="row row-flush">
						<div class="col-4 bg-'.$bg.' text-center d-flex align-items-center justify-content-center rounded-left">
							<em class="'.$icona.' fa-2x"></em>
						</div>
						<div class="col-8">
							<div class="card-body text-center">
								<h4 class="mt-0">'.$valore.'
									'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'
								</h4>
								<p class="mb-0 text-muted">'.$titolo.'</p>
							</div>
						</div>
					</div>'
					.(!is_null($link) ? '
					<a class="card-footer bg-gray-dark bt0 clearfix btn-block d-flex" href="'.$link.'">
						<span>'.$testo_link.'</span>
						<span class="ml-auto">
							<em class="fa fa-chevron-circle-right"></em>
						</span>
					</a>' : '')
					.'
				</div>
				<!-- END card-->';
				break;

			default:
				//do nothing
		}
		self::statContent($content, $boxclass);
	}
}