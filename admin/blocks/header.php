<?php

include_once('head.php');

$pages = [
	['href' => '/admin/index.php?act=update&tp=articles', 'text' => 'Статьи'],
	['href' => '/admin/comments.php', 'text' => 'Комментарии'],
	['href' => '/admin/index.php?act=update&tp=news', 'text' => 'Новости'],
	['href' => '/admin/index.php?act=update&tp=pages', 'text' => 'Страницы'],
	['href' => '/admin/index.php?act=update&tp=program', 'text' => 'Программы'],
	['href' => '/', 'text' => 'Сайт'],
];
?>
<body class="bg-light">
<div class="container">
	<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
		<a href="/admin/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
			<img src="../images/sol.gif" width="70%" height="35px" alt="SkeitOL" style="max-width:100px;"/>
		</a>
		<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
			<?php
			$curPage = $_SERVER['REQUEST_URI'];
			foreach ($pages as $page) {
				$href = $page['href'];
				if ($curPage == $href) {
					$href = '';
				}
				if ($href) {
					?><a class="nav-link px-2 link-secondary" href="<?= $href ?>"><?= $page['text'] ?></a><?
				} else {
					?><span class="nav-link px-2 link-secondary active disabled"><?= $page['text'] ?></span><?
				}
			}
			?>
		</ul>
		<div class="col-auto text-end">
			<?php
			if ($_SERVER['PHP_AUTH_USER']) {
				$user = \SkeitOl\Connection::getInstance()->query("SELECT * FROM userlist WHERE user='" . $_SERVER['PHP_AUTH_USER'] . "'")->fetch();
				$user_name = $user['FIRST_NAME'];
				$img_src = $user['IMG_SRC'];
				$user_id = $user['id'];
				?>
				<div class="flex-shrink-0 dropdown">
					<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" alt="<?= $user_name ?>" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="images/ava/<?= $user_id ?>/<?= $img_src ?>" alt="mdo" width="32" height="32" class="rounded-circle">
					</a>
					<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
						<li><a class="dropdown-item" href="user.php?edit_user=<?= $user_id ?>">Profile</a></li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<a class="dropdown-item" href="lock.php?exit" title="Выйти из панели администратора" alt="Выйти из панели администратора">выйти</a>
						</li>
					</ul>
				</div>
				<?php
			}
			?>
		</div>
	</header>


	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/admin/">Главная</a></li>
			<?php
			global $PAGINATION;
			$n = count($PAGINATION);
			for ($i = 0; $i < $n; $i++) {
				$text = $PAGINATION[$i]['text'];
				$href = $PAGINATION[$i]['href'];
				$isActive = false;
				if ($i == $n - 1) {
					$isActive = true;
					$href = '';
				}
				?>
				<li class="breadcrumb-item<?= $isActive ? ' active' : '' ?>" aria-current="page"><?php
					if ($href) {
						echo "<a href=\"$href\" title='$text'>";
					}
					echo $text;
					if ($href) {
						echo "</a>";
					}
					
					?></li>
				<?php
			}
			?>

		</ol>
	</nav>
</div>