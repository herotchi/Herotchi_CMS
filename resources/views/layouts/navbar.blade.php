<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><strong>Herotchi_CMS<span class="text-danger ps-2">管理画面</span></strong></a>
    <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-expanded="false" aria-controls="offcanvasNavbar" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">オフキャンバス</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="閉じる"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link {{--active--}}" {{--aria-current="page"--}} href="">TOP</a>
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
        <form class="d-flex mt-3 mt-lg-0" role="search">
          <button class="btn btn-outline-success flex-shrink-0" type="submit">ログアウト</button>
        </form>
        {{--<form class="d-flex mt-3 mt-lg-0" role="search">
          <input type="search" class="form-control me-2" placeholder="検索" aria-label="検索">
          <button class="btn btn-outline-success flex-shrink-0" type="submit">検索</button>
        </form>--}}
      </div>
    </div>
  </div>
</nav>