<?php
namespace DeployStudio\Style\Bootswatch;

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
	static function stat ($variante, $bg, $icona, $titolo, $valore, $ext = null, $boxclass = 'col-xs-12',
		$link = null, $testo_link = 'Maggiori dettagli', $progress_percent = null, $progress_description = null) {
		switch ($variante) {
			case 1:
				$bg_progress = $bg;
				if (in_array($bg_progress, array('gray', 'gray-active', 'gray-light'))) {
					$bg_progress = 'black';
				}
				$content = '
				<div class="info-box">
					<span class="info-box-icon bg-'.$bg.'"><i class="'.$icona.'"></i></span>
		
					<div class="info-box-content">
						<span class="info-box-text">'.$titolo.'</span>
						<span class="info-box-number">'.$valore.'
						'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'</span>

						'.(!is_null($progress_percent) ? '
						<div class="progress">
							<div class="progress-bar bg-'.$bg_progress.'" style="width: '.$progress_percent.'%;"></div>
						</div>
						' : '')
						.'

						'.(!is_null($progress_description) ? '
						<span class="progress-description">
							'.$progress_description.'
						</span>
						' : '')
						.'
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->';


				/*$content = '<!-- START card-->
				<div class="card bg-'.$bg.' border-0">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-3">
								<em class="'.$icona.' fa-5x"></em>
							</div>
							<div class="col-9 text-right">
								<div class="text-lg">
								</div>
								<p class="m-0"></p>
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
				<!-- END card-->';*/
				break;

			case 2:
				$content = '
				<div class="info-box bg-'.$bg.'">
					<span class="info-box-icon"><i class="'.$icona.'"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">'.$titolo.'</span>
						<span class="info-box-number">'.$valore.'
							'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'</span>

						'.(!is_null($progress_percent) ? '
						<div class="progress">
							<div class="progress-bar" style="width: '.$progress_percent.'%"></div>
						</div>
						' : '')
						.'

						'.(!is_null($progress_description) ? '
						<span class="progress-description">
							'.$progress_description.'
						</span>
						' : '')
						.'
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->';
				break;

			case 3:
				$content = '
				<!-- small box -->
				<div class="small-box bg-'.$bg.'">
					<div class="inner">
						<h3>'.$valore.'
						'.(!is_null($ext) ? '<small>'.$ext.'</small>' : '').'</h3>

						<p>'.$titolo.'</p>
					</div>
					<div class="icon">
						<i class="'.$icona.'"></i>
					</div>

					'
					.(!is_null($link) ? '
					<a href="'.$link.'" class="small-box-footer">
						'.$testo_link.' <i class="fa fa-arrow-circle-right"></i>
					</a>' : '')
					.'
				</div>';
				break;

			default:
				//do nothing
		}
		self::statContent($content, $boxclass);
	}
}