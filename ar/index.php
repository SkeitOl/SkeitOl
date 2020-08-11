<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/header.php");
?>
<section class="grid">
	<header class="top-bar">
		<h2 class="top-bar__headline">Статьи</h2>
		<div class="filter">
			<span>Filter by:</span>
			<span class="dropdown">Popular</span>
			<span class="dropdown">Popular</span>
		</div>
	</header>
	<style>
		body {
			font: 14px 'Calibri', 'Century Gothic';
			font-family: "Segoe UI", "Helvetica Neue", Helvetica, sans-serif;
			font-family: 'Open Sans', sans-serif;
			line-height: 1.38461538;
			color: #333;
		}

		.sidebar h1 {
			color: #ec7330;
			font-family: 'Open Sans', sans-serif;

			font-weight: 300;

		}

		.title {
			/*text-shadow: 1px 1px 5px #000;*/
			font-family: 'Open Sans', sans-serif;
			font-size: 1.5rem;
			font-weight: 800;


		}

		.loader::before {
			background: #ec7330
		}

		a {
			color: #ec7330
		}

		.grid__item:hover::before {
			border: 3px solid rgb(236, 114, 47);
		}

		.content__item--show .title--full {
			margin: 0 0 30px;
		}


		pre {
			word-wrap: break-word;
			padding: 5px 5px 5px 9px;
			border-left: 4px solid #f2a559;
			background: #eee;
			box-shadow: none;
			overflow: auto;
		}
	</style>
	<?php
	$arItems = $SKEITOL->GetList('articles',
		[
			"filter"  => ["active" => 1],
			"limit"  => ["top" => 12],
			"select" => ["id", 'title', 'date', 'description', 'author', 'url', 'src_preview', 'TIMESTAMP_X', 'views', 'text'],
			'order'  => ['date' => "desc"]
		]
	);
	foreach ($arItems as $arItem) {
		?>
		<a class="grid__item" href="<?= $arItem["url"] ?>">
			<?//$SKEITOL->dump($arItem)
			?>
			<div class="bg" style="background-image:url('<?= $arItem["src_preview"] ?>')"></div>
			<h2 class="title title--preview">
				<span class="text"><?= $arItem["title"] ?></span></h2>
			<div class="loader"></div>
			<?/*<span class="category"><?=$arItem["description"]?></span>*/
			?>
			<div class="meta meta--preview">
				<?/*<img class="meta__avatar" src="<?=$arItem["src_preview"]?>" alt="<?=$arItem["title"]?>" />*/
				?>
				<span class="meta__date"><i class="fa fa-calendar-o"></i> <?= $arItem["date"] ?></span>
				<span class="meta__reading-time"><i class="fa fa-clock-o"></i> <?= $arItem["views"] ?></span>
			</div>
		</a>
		<?
	}
	?>
	<footer class="page-meta">
		<span>Load more...</span>
	</footer>
</section>
<section class="content">
	<div class="scroll-wrap">
		<?
		foreach ($arItems as $arItem) {
			?>
			<article class="content__item">
				<span class="category category--full"></span>
				<h2 class="title title--full"><?= $arItem['title'] ?></h2>
				<div class="meta meta--full">
					<? /*<span class="meta__author"><?=$arItem['author']?></span>*/
					?>
					<span class="meta__date"><i class="fa fa-calendar-o"></i> <?= $arItem["date"] ?></span>
					<span class="meta__reading-time"><i class="fa fa-clock-o"></i> <?= $arItem["views"] ?></span>
				</div>
				<div class="description">
					<?= $arItem['text'] ?>
				</div>
			</article>
			<?
		} ?>
	</div>
	<button class="close-button"><i class="fa fa-close"></i><span>Close</span></button>
</section>
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/footer.php");
?>
