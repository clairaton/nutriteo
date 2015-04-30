		<div class="btn-group" id="btn">
			<a href="carnet.php"><button class="btn btn-success">Jour</button></a>
			<a href="carnet.php?date_range=week"><button class="btn btn-success">Semaine</button></a>
			<a href="carnet.php?date_range=month"><button class="btn btn-success">Mois</button></a>
		</div>

		<div class="panel-group" id="accordion">
		<?php
			$i = 0;
			foreach ($tab_nutriements as $nutriement) {
				$nutriment_list = Nutriment::getListByFamily($nutriement['id']);
			?>

			<div class="panel panel-default nutriement" id="<?= $nutriement['id'] ?>">
				<div class="panel-heading" id="panel-family">
					<h3 class="col-md-3 col-sm-12 col-xs-7">
						<span class="question" ><a href="javascript:void(0);" rel="info" title="test info bull">?</a></span>

						<a href="nutrition.php?family_id=<?= $nutriement['id']; ?>" name="<?= $nutriement['id'] ?>"  ><?=$nutriement['name'] ?></a>

					</h3><!--End of h3-->

					<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
						<div class="progress col-md-7 col-sm-10 col-xs-10">
							<div class="progress-bar" style="width: <?=$nutriement['realisation']*100 ?>%"><?= intval($nutriement['realisation']*100) ?>%</div>
						</div>
					</a>
					<h3><?= intval($nutriement['real_quantity']) ?> / <?= intval($nutriement['obj_quantity']) ?> <?= $nutriement['unity'] ?></h3>
				</div>
				<div id="collapse<?= $i ?>" class="panel-collapse collapse in">
			    	<div class="panel-body">

			    		<?php
			    		// pour chaque nutriment de la famille
						foreach ($nutriment_list as $item) {
							$id = $item -> getId();
							?>
							<div class="panel-heading">
								<h3 class="col-md-3 col-sm-4 col-xs-12 panel-title">
									<span class="question" ><a href="javascript:void(0);" rel="info" title="test info bull">?</a></span>

									<a href="nutrition.php?id=<?= $dashboard_by_nutriment[$id]['id']; ?>" name="<?= $dashboard_by_nutriment[$id]['id'] ?>"  ><?=$dashboard_by_nutriment[$id]['name'] ?></a>

								</h3><!--End of h3-->

								<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
									<div class="progress col-md-7 col-sm-6 col-xs-10 ">
										<div class="progress-bar" style="width: <?=$dashboard_by_nutriment[$id]['realisation']*100 ?>%"><?= intval($dashboard_by_nutriment[$id]['realisation']*100) ?>%</div>
									</div>
								</a>

							</div>
						<?php } ?>


			    	</div>
			    </div>
			</div>
		<?php $i++; } ?>
		</div><!--End of accordion-->

	<form method="GET" action="nutrition.php">
		<?php foreach ($tab_nutriements as $nutriement) { ?>
			<div id="info-<?= $nutriement['id'] ?>" class="info">
			<?= Utils::cutString($nutriement['description'], 50, '...')?><br>
			<a href="nutrition.php?nom=<?= $nutriement['name']; ?>" name="<?= $nutriement['id'] ?>">En savoir plus</a>
			</div>
		<?php } ?>
	</form>



