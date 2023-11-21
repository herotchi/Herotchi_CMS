<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark mb-3" data-bs-theme="dark">
  	<div class="container-fluid">
    	<a class="navbar-brand" href="#"><strong>Herotchi_CMS<span class="text-danger ps-2">管理画面</span></strong></a>
    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
    	</button>
    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
      		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
        		<li class="nav-item">
          			<a class="nav-link {{--active--}}" {{--aria-current="page"--}} href="#">TOP</a>
        		</li>
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">お知らせ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">お知らせ登録</a></li>
                        <li><a class="dropdown-item" href="#">お知らせ一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">カテゴリ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">大カテゴリ登録</a></li>
                        <li><a class="dropdown-item" href="#">大カテゴリ一覧</a></li>
                        <li><a class="dropdown-item" href="#">中カテゴリ登録</a></li>
                        <li><a class="dropdown-item" href="#">中カテゴリ一覧</a></li>
                        <li><a class="dropdown-item" href="#">カテゴリ一括登録</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">製品情報</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">製品情報登録</a></li>
                        <li><a class="dropdown-item" href="#">製品情報一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">メディア</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">メディア登録</a></li>
                        <li><a class="dropdown-item" href="#">メディア一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">お問い合わせ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">お問い合わせ一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ユーザー</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">ログイン情報変更</a></li>
                    </ul>
                </li>
      		</ul>
              {{--<a class="btn btn-outline-success" href="#" role="button">ログアウト</a>--}}
            <form class="" action="{{ route('admin.auth.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-success" type="submit">ログアウト</button>
            </form>
    	</div>
  	</div>
</nav>
