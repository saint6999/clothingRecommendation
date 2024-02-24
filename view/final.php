<?php
	require_once('./inc/functions.php');
	require_once('./controller/clotheController.php');

	$functions = new Functions();
	$clotheController = new clotheController();

	if(!isset($_GET['clothe_id'])){

		exit();
	}
	//pega a peça de id igual a $_GET['clothe_id']
	$clothePurchased = json_decode($clotheController->getclothe($_GET['clothe_id']));

	//realiza a "compra"
	$clotheController->buy($clothePurchased->id);

	//realiza a recomendação de 3 peças de roupa
	$top3 = $functions->getRecommendation($clothePurchased);	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Final</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="view/style.css">
	</head>
	<body>
		<h1 class="title">Purchase made</h1>

		<div id="final" class="container">
			<div class="clothe-card">
				<img src="<?=$clothePurchased->image ?>" alt="<?= $clothePurchased->name ?>" />
				<h5><?= $clothePurchased->name ?></h5>

				<div class="purchased-info">
					<p>Gender - <?= $clothePurchased->gender ?></p>
					<p>Material - <?= $clothePurchased->material ?></p>
					<p>Color - <?= $clothePurchased->color ?></p>
					<p>Origin- <?= $clothePurchased->origin ?></p>
					<p>Type- <?= $clothePurchased->type ?></p>
				</div>
			</div>

			<p>O item <strong><?= $clothePurchased->name ?></strong> your shopping list has been added.</p>
			<a href="?p=home">To go back</a>					
		</div>

		<?php echo ($top3)? "<h2 class='title'>Complete your look</h2>": '' ?>

		<div id="recommendation">
			<?php
			if ($top3) {

				foreach ($top3 as $clotheRecommended) {
			?>
				<div class="clothe-card">
					<img src="<?=$clotheRecommended->image ?>" alt="<?= $clotheRecommended->name ?>" />
					<h5><?= $clotheRecommended->name ?></h5>

					<div class="info">
						<p>Gender - <?= $clotheRecommended->gender ?></p>
						<p>Material - <?= $clotheRecommended->material ?></p>
						<p>Color - <?= $clotheRecommended->color ?></p>
						<p>Origin - <?= $clotheRecommended->origin ?></p>
						<p>Type - <?= $clotheRecommended->type ?></p>
					</div>
					
					<?php
						if($functions->alreadyPurchased($clotheRecommended->id)){
							echo "<p class='purchased'>Bought</p>";
						}else{
							echo "<a href='?p=final&clothe_id=".$clotheRecommended->id."'>Buy</a>";
						}
					?>

				</div>
			<?php
				}
			}else{
				?>
				<h2 style="color: #000;">Parts available in STock</h2>
				<?php
			}
			?>
		</div>

		<footer>
		</footer>
	</body>
</html>